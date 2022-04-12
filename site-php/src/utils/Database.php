<?php

namespace WebtoonLike\Site\utils;

use mysqli;
use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\Settings;

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

    public static function getAll(string $table, string $entityClass, string|array $select, array $where): array {
        $selectedColumns = self::getSelectedColumns($select, $entityClass);
        $whereConditions = sizeof($where) > 0 ? ' WHERE' . self::getWhereConditions($where, $entityClass) : '';
        $q = "SELECT $selectedColumns FROM `$table` $whereConditions;";
        $res = self::getDB()
            ->query($q)
            ->fetch_all(MYSQLI_ASSOC);
        return self::responseToObjects($res, $entityClass);
    }

    public static function getFirst(string $table, string $entityClass, string|array $select, array $where): ?EntityInterface {
        $selectedColumns = self::getSelectedColumns($select, $entityClass);
        $whereConditions = sizeof($where) > 0 ? ' WHERE' . self::getWhereConditions($where, $entityClass) : '';
        $q = "SELECT $selectedColumns FROM `$table` $whereConditions;";
        $res = self::getDB()
            ->query($q)
            ->fetch_assoc();
        return self::responseToObjects([$res], $entityClass)[0] ?? null;
    }

    public static function remove($table, EntityInterface $entity): bool {
        $where = self::whereIds($entity);
        $q = "DELETE FROM `$table` WHERE $where";
        return self::getDB()
            ->query($q);
    }

    public static function edit(string $table, EntityInterface $entity): bool {
        $sets = self::buildEditSet($entity);
        $where = self::whereIds($entity);
        $q = "UPDATE `$table` SET $sets WHERE $where;";
        return self::getDB()->query($q);
    }


    private static function whereIds(EntityInterface $entity): string {
        $where = '';
        foreach ($entity::getIdentifiers() as $id) {
            $value = $entity->__toArray()[$id];
            $where .= "$id = $value" . ' AND ';
        }
        return substr($where, 0, -5);
    }

    private static function buildEditSet(EntityInterface $entity): string {
        $res = '';
        foreach ($entity->getFieldsToSave() as $key => $value) {
            $value = is_string($value) ? "'$value'" : $value;
            $res .= $key . ' = ' . $value . ', ';
        }
        return substr($res, 0, -2);
    }

    private static function testIfColumnKeysExistsOnEntity(array $keys, string $entityClass): void {
        foreach ($keys as $key) {
            if (!in_array($key, $entityClass::getColumnsKeys())) {
                throw new \InvalidArgumentException("Key $key does not exist on entity $entityClass.");
            }
        }
    }

    private static function getSelectedColumns(string|array $select, string $entityClass): string {
        if ($select === '*') return $select;
        if (is_string($select)) throw new \InvalidArgumentException('Select can only be \'*\' or an array of columns.');
        self::testIfColumnKeysExistsOnEntity($select, $entityClass);
        return join(', ', $select);
    }

    private static function getWhereConditions(array $where, string $entityClass): string {
        $res = '';
        foreach ($where as $key => $value) {
            self::testIfColumnKeysExistsOnEntity(mb_split(',', $key), $entityClass);
            $res .= ' ' . $value;
        }
        return $res;
    }

}