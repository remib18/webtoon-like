<?php

namespace WebtoonLikeSitePhp\controller;

interface ControllerInterface
{

    /**
     * Obtention de toutes les ressources
     *
     * @return mixed[]
     */
    public function getAll(): array;

    /**
     * Obtention de la ressource avec l'identifiant correspondant.
     * @param int $id Identifiant rechercher
     * @return mixed
     */
    public function getById(int $id): mixed;

    /**
     * Obtention de la ressource avec le nom correspondant.
     * @param string $name Nom rechercher
     * @return mixed
     */
    public function getByName(string $name): mixed;

    /**
     * Enregistre une ressource et retourne son identifiant ou <code>false</code> en cas d'erreur.
     *
     * @param array $params
     * @return int|false
     */
    public function create(array $params): int | false;

    /**
     * Modifie la ressource correspondant à l'identifiant <code>id</code> avec les paramètres donnés.
     *
     * @param int $id Identifiant de la ressource à modifier
     * @param array $params Données à modifier. (Partiel de la donnée)
     * @return bool Retourne vrai si la modification a été effectuée avec succès.
     */
    public function edit(int $id, array $params): bool;

    /**
     * Supprime la ressource correspondant à l'identifiant fournit.
     * @param int $id L'identifiant de la ressource à supprimer.
     * @return bool Retourne vrai si la suppression a été effectuée avec succès.
     */
    public function remove(int $id): bool;

}