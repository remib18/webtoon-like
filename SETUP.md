# Configuration du serveur WEB
Si vous utilisez Appache:
  - localiser `httpd.conf` (CentOS/RHEL/Fedora/MAMP) ou `apache2.conf` (Ubuntu/Debian)
  - trouver la directive `<Directory></Directory>`
  - changer `AllowOverride None` pour `AllowOverride All`

Changer la racine pour deservir le dossier `/site-php`


# Configuration du serveur PHP

Afin d'assurer le bon fonctionnement de l'application, nous recommandons l'utilisation de `PHP 8.1`.

# Paramétrage de la base de donnée

## Configuration du site

Rendez-vous au fichier `site-php/src/settings.php` puis recherchez les ligne suivante :

```php
host => 'localhost'
username => 'root'
password => ''
dbName => 'webtoonLike'
port => ''
socket => ''
```

## Création de la base
- Initialisation
  - Se rendre dans le dossier `/sql/init/`
  - Importer le fichier `init-db_v0.sql`
- Import de données test
  - Se rendre dans le dossier `/sql/import/`
  - Importer le fichier `import-db_v0.sql`
