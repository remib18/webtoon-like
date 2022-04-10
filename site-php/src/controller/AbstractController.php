<?php

namespace WebtoonLike\Site\controller;

use WebtoonLike\Site\entities\EntityInterface;
use WebtoonLike\Site\utils\Database;

abstract class AbstractController {

    private \mysqli $db;

    public function __construct(string $table) {
        $this->db = Database::getDB();
    }

    /**
     * Obtention de toutes les ressources
     *
     * @return EntityInterface[]
     */
    abstract public static function getAll(): array;

    /**
     * Obtention de la ressource avec l'identifiant correspondant.
     * @param int $id Identifiant rechercher
     * @return mixed
     */
    abstract public static function getById(int $id): EntityInterface;

    /**
     * Obtention de la ressource avec le nom correspondant.
     * @param string $name Nom rechercher
     * @return mixed
     */
    abstract public static function getByName(string $name): EntityInterface;

    /**
     * Enregistre une ressource et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param EntityInterface $entity
     * @return int|false
     */
    abstract public static function create(EntityInterface $entity): int | false;

    /**
     * Modifie la ressource
     *
     * @param EntityInterface $entity La ressource modifiée
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    abstract public static function edit(EntityInterface $entity): bool;

    /**
     * Supprime la ressource correspondant à l'identifiant fournit.
     * @param int $id L'identifiant de la ressource à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    abstract public static function removeById(int $id): bool;

}