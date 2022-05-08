<?php

namespace WebtoonLike\tests;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use WebtoonLike\Site\Settings;

// Réécriture des paramètres du php.ini de manière temporaire pour les tests.
ini_set('xdebug.var_display_max_depth', 10);

// Verify access
if (Settings::get('production')) {
    header('Location: /error?msg=' . urlencode('Page inexistante.'));
}

// Get files
$handle = opendir(__DIR__);
$files = [];
while ($file = readdir($handle)) {
    preg_match('/[a-zA-Z_]+\.test\.php/', $file, $matches);
    if (isset($matches[0])) {
        $files[] = $file;
    }
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tests</title>
</head>
<body>

<h1>WebtoonLike — Tests</h1>
<table>
    <thead>
    <tr>
        <th>Test</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($files as $file): ?>
        <tr>
            <td><a href="<?= 'src/tests/' . $file ?>"><?= $file ?></a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

</body>
</html>
