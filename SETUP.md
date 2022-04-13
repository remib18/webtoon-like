# Configuration du serveur WEB

Si vous utilisez Apache:
  - localiser `httpd.conf` (CentOS/RHEL/Fedora/MAMP) ou `apache2.conf` (Ubuntu/Debian)
  - trouver la directive `<Directory {chemin vers la racine du site}></Directory>`
  - changer `AllowOverride None` pour `AllowOverride All`

Changer la racine pour desservir le dossier `/site-php`

# Obtention et installation

## Version de PHP

Afin d'assurer le bon fonctionnement de l'application, nous recommandons l'utilisation de `PHP 8.1`.
Des erreurs adviendront pour une version de `PHP < 8.0` vu que nous utilisions des fonctionnalités de cette version
dont les enums, le typage avancé (eg. `string|int`)...

## Téléchargement

Nous recommandons l'installation du projet à l'aide de Git [(lien d'installation)](https://git-scm.com/downloads).

De manière alternative,
1. Rendez-vous sur [le repos du projet (Github)](https://github.com/remib18/webtoon-like)
2. Cliquez sur le bouton vert Code
3. Cliquez sur Download ZIP

```shell
cd LE_CHEMIN_VERS_VOTRE_SERVEUR_WEB

# Notez que git va créer un dossier webtoon-like
# Le serveur web se trouve dans webtoon-like/site-php
git clone https://github.com/remib18/webtoon-like.git
```

## Installation des dépendances à l'aide de Composer

Par la suite vous devrez lancer l'installation des dépendances à l'aide de Composer
[(lien d'installation)](https://getcomposer.org/download/).

```shell
# On suppose que vous vous situez au niveau du dossier du point précédent (celui du projet)
# On accède au serveur web
cd webtoon-like/site-php

# Installation des dépendances
composer install
```



# Paramétrage de la base de donnée

## Configuration du site

Rendez-vous au fichier `site-php/src/Settings.php` puis recherchez les lignes suivantes dans la propriété settings :

```php
'host' => 'localhost'
'username' => 'root'
'password' => ''
'dbName' => 'webtoonLike'
'port' => ''
'socket' => ''
```

## Création de la base

**Note:** Vous pouvez importer le fichier dans la base mysql avec cette commande
`mysql -u UTILISATEUR -p < CHEMIN_DU_FICHIER`.

```shell
# Exemple d'exécution

# Repositionnez vous à la racine
cd ..

# Chargez les fichiers dans mysql (vous pouvez également utiliser phpMyAdmin)
# Si l'utilisateur root n'a pas de mot de passe (ce référer plus haut pour la commande complète)
mysql -u root < sql/init/init-db_v0.sql
mysql -u root < sql/import/import-db_v0.sql

```

### Liste des scripts
*Paths relatifs par rapport au dossier root du projet (webtoon-like).*
- Initialisation: `sql/init/init-db_v0.sql`
- Import de données test: `sql/import/import-db_v0.sql`
