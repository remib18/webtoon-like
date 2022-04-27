<?php

namespace WebtoonLike\Site\utils;

use InvalidArgumentException;
use mysqli;
use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\entities\NoIdOverwritingException;
use WebtoonLike\Site\exceptions\UnsupportedOperationException;
use WebtoonLike\Site\Settings;
use WebtoonLike\Site\utils\DataTesting\DataVerification;

class Database
{
    private static mysqli $db;

    /**
     * Obtenir l'instance de la base de données
     *
     * @return mysqli
     */
    public static function getDB(): mysqli {
        if (!isset(self::$db)) {
            self::$db = new mysqli(...Settings::get('DATABASE'));
        }
        return self::$db;
    }

    public static function runTests(EntityInterface $entity): bool {
        $res =true;
        foreach ($entity as $field) {
            // If True, True, True => True
            // If True, True, False => False
            $res = DataVerification::verify($field) && $res ;
        }
        return $res;
    }

    /**
     * Transforme une réponse mysqli en tableau d'objets
     *
     * @param array $response Réponse mysqli avec un fetchAll assoc
     * @param string $class Classe représentant les objects
     *
     * @return EntityInterface[]|null
     */
    public static function responseToObjects(array $response, string $class): ?array {
        $res = [];
        if (sizeof($response) === 1 && is_null($response[0])) return null;
        foreach ($response as $item) {
            $res[] = new $class(...$item);
        }
        return $res;
    }

    /**
     * Obtenir le dernier index insérer par auto_increment
     *
     * @return int
     */
    public static function getLastInsertedId(): int {
        $q = 'SELECT LAST_INSERT_ID();';
        return self::getDB()->query($q)->fetch_row()[0];
    }

    /**
     * Retourne toutes les ressources dans la table
     *
     * @param string $table La table
     * @param string $entityClass Le nom de la class d'entité (obtenu avec RessourceEntity::class)
     * @param string|array $select '*' ou un tableau contenant les noms des champs à sélectionner
     * @param array $where Tableau contenant comme clé le nom des champs utilisé, séparer par des virgules et les tests
     *
     * @return EntityInterface[] Un tableau de l'entité correspondante à celle souhaité
     */
    public static function getAll(string $table, string $entityClass, string|array $select, array $where): array {
        $selectedColumns = self::getSelectedColumns($select, $entityClass);
        $whereConditions = sizeof($where) > 0 ? ' WHERE' . self::getWhereConditions($where, $entityClass) : '';
        $q = "SELECT $selectedColumns FROM `$table` $whereConditions;";
        $res = self::getDB()
            ->query($q)
            ->fetch_all(MYSQLI_ASSOC);
        return self::responseToObjects($res, $entityClass);
    }

    /**
     * Retourne la première ressource correspondante
     *
     * @param string $table La table
     * @param string $entityClass Le nom de la class d'entité (obtenu avec RessourceEntity::class)
     * @param string|array $select '*' ou un tableau contenant les noms des champs à sélectionner
     * @param array $where Tableau contenant comme clé le nom des champs utilisé, séparer par des virgules et les tests
     *
     * @return EntityInterface|null L'entité correspondante à celle souhaité ou null si inexistant
     */
    public static function getFirst(string $table, string $entityClass, string|array $select, array $where): ?EntityInterface {
        $selectedColumns = self::getSelectedColumns($select, $entityClass);
        $whereConditions = sizeof($where) > 0 ? ' WHERE' . self::getWhereConditions($where, $entityClass) : '';
        $q = "SELECT $selectedColumns FROM `$table` $whereConditions;";
        $res = self::getDB()
            ->query($q)
            ->fetch_assoc();
        return self::responseToObjects([$res], $entityClass)[0] ?? null;
    }

    /**
     * Supprime la ressource et renvoie vrai si l'opération a été effectué avec succès.
     *
     * @param string          $table Le nom de la table
     * @param EntityInterface $entity La ressource à supprimer
     *
     * @return bool
     */
    public static function remove(string $table, EntityInterface $entity): bool {
        $where = self::whereIds($entity);
        $q = "DELETE FROM `$table` WHERE $where";
        return self::getDB()
            ->query($q);
    }

    /**
     * Crée une ressource dans la base de donnée
     *
     * @param string          $table  Le nom de la table
     * @param EntityInterface $entity La ressource à enregistrer
     *
     *                                La ressource est modifiée avec son nouvel identifiant
     *
     * @return bool Faux en cas d'erreur
     * @throws NoIdOverwritingException
     */
    public static function create(string $table, EntityInterface &$entity): bool {
        $fields = '';
        $values = '';
        foreach ($entity->getFieldsToSave() as $key => $value) {
            $fields .= "`$key`, ";
            $values .= self::normalizeValue($value) . ', ';
        }
        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);
        $q = "INSERT INTO `$table`($fields) VALUE ($values)";
        $res = Database::getDB()->query($q);
        if ($res) {
            $entity->AllFieldsSaved();
            $entity->setId(self::getLastInsertedId());
            // return self::getLastInsertedId();
        }
        return $res;
    }

    /**
     * Enregistrer une liste d'entités dans la base de données
     *
     * @param string            $table    Le nom de la table
     * @param EntityInterface[] $entities Les ressources à enregistrer
     *
     * @return bool
     * @throws NoIdOverwritingException
     * @throws UnsupportedOperationException
     */
    public static function createBatch(string $table, array &$entities): bool {
        $fields = join(', ', array_keys($entities[0]->getFieldsToSave()));
        $values = self::insertValues($entities);
        $q = "INSERT INTO `$table`($fields) VALUES $values";
        $res = Database::getDB()->query($q);
        if ($res) {
            $result = [];
            $id = self::getLastInsertedId();
            foreach ($entities as $entity) {
                $entity->setId($id);
                try {
                    $result[$entity->getId()] = $entity;
                } catch (\Exception|\Error) {
                    throw new UnsupportedOperationException('Impossible to perform a create ressource batch request on entity ' . $entities[0]::class . '.');
                }
                $id++;
            }
            $entities = $result;
            return true;
        }
        return false;
    }

    /**
     * Modifie une ressource dans la base de donnée
     *
     * @param string          $table  Le nom de la table
     * @param EntityInterface $entity La ressource modifiée
     *
     * @return bool Faux en cas d'erreur
     */
    public static function edit(string $table, EntityInterface &$entity): bool {
        $sets = self::buildEditSet($entity);
        $where = self::whereIds($entity);
        $q = "UPDATE `$table` SET $sets WHERE $where;";
        $res =  self::getDB()->query($q);
        if ($res) {
            $entity->AllFieldsSaved();
        }
        return $res;
    }

    /**
     * Obtention des valeurs d'insertion
     *
     * @param EntityInterface[] $entities
     *
     * @return string
     */
    private static function insertValues(array $entities): string {
        $res = '';
        foreach ($entities as $entity) {
            $fields = [];
            foreach ($entity->getFieldsToSave() as $item) {
                $fields[] = self::normalizeValue($item);
            }
            $res .= '(' . join(', ', $fields) . '),';
        }
        return substr($res, 0, -1);
    }

    /**
     * Obtention du where pour une recherche par identifiants
     *
     * @param EntityInterface $entity
     *
     * @return string
     */
    private static function whereIds(EntityInterface $entity): string {
        $where = '';
        foreach ($entity::getIdentifiers() as $id) {
            $value = $entity->__toArray()[$id];
            $where .= "`$id` = $value" . ' AND ';
        }
        return substr($where, 0, -5);
    }

    /**
     * Construit la partie set d'une requête update.
     *
     * @param EntityInterface $entity
     *
     * @return string
     */
    private static function buildEditSet(EntityInterface $entity): string {
        $res = '';
        foreach ($entity->getFieldsToSave() as $key => $value) {
            $value = self::normalizeValue($value);
            $res .= "`$key` = $value, ";
        }
        return substr($res, 0, -2);
    }

    /**
     * Ajoute des guillemets si chaine de caractère
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function normalizeValue(mixed $value): string {
        if (is_null($value)) return 'null';
        if (is_bool($value)) return $value ? 'true' : 'false';
        return is_string($value) ? "'" . self::getDB()->escape_string($value) . "'" : (string)$value;
    }

    /**
     * Vérifie l'existence de la colonne dans la table
     * Note: pourrait avoir été effectué avec des requêtes, mais risque de surcharge de la base.
     *
     * @param array  $keys
     * @param string $entityClass
     *
     * @return void
     */
    private static function testIfColumnKeysExistsOnEntity(array $keys, string $entityClass): void {
        foreach ($keys as $key) {
            if (!in_array($key, $entityClass::getColumnsKeys())) {
                throw new InvalidArgumentException("Key $key does not exist on entity $entityClass.");
            }
        }
    }

    /**
     * Construit la liste des colonnes sélectionnées
     *
     * @param string|array $select
     * @param string       $entityClass
     *
     * @return string
     */
    private static function getSelectedColumns(string|array $select, string $entityClass): string {
        if ($select === '*') return $select;
        if (is_string($select)) throw new InvalidArgumentException('Select can only be \'*\' or an array of columns.');
        self::testIfColumnKeysExistsOnEntity($select, $entityClass);
        return join(', ', $select);
    }

    /**
     * Construit une condition where
     *
     * @param array  $where
     * @param string $entityClass
     *
     * @return string
     */
    private static function getWhereConditions(array $where, string $entityClass): string {
        $res = '';
        foreach ($where as $key => $value) {
            self::testIfColumnKeysExistsOnEntity(mb_split(',', $key), $entityClass);
            $res .= ' ' . $value;
        }
        return $res;
    }

}