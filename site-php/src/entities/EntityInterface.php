<?php

namespace WebtoonLike\Site\entities;

use WebtoonLike\Site\exceptions\AlreadyExistingRessourceException;

interface EntityInterface
{

    /**
     * Transforme l'entité en un tableau dont les champs sont indexés par rapport aux noms des colonnes de la BDD.
     *
     * @return array<string, mixed>
     */
    public function __toArray(): array;

    /**
     * Retourne l'ensemble des noms de colonne de la table correspondante dans la BDD.
     *
     * @return string[]
     */
    public static function getColumnsKeys(): array;

    /**
     * Retourne la liste des identifiants de l'entité.
     *
     * @return string[]
     */
    public static function getIdentifiers(): array;

    /**
     * Retourne la liste des types des champs.
     *
     * @return array<string, string>
     */
    public static function getTypes(): array;

    /**
     * Retourne la liste des champs modifiés à sauvegarder dans la BDD.
     *
     * @return array<string, mixed>
     */
    public function getFieldsToSave(): array;

    /**
     * Enregistre la sauvegarde des données
     * Attention, ne doit être exécuté que si les données ont bien été enregistrées dans la BDD !
     *
     * @return void
     */
    public function AllFieldsSaved(): void;

    /**
     * Définit l'identifiant après enregistrement dans la base de données.
     * Si la ressource a déjà un identifiant, retourne une erreur.
     *
     * @param int $id
     *
     * @return void
     *
     * @throws NoIdOverwritingException
     */
    public function setId(int $id): void;

}