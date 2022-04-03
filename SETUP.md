# Utilisation de la base de donnée

## Paramétrage MySQL

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
