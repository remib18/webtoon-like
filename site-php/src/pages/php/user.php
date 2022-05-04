<?php require dirname(__DIR__, 2) . '/components/header.php';

$user = \WebtoonLike\Site\controller\UserController::getById($_SESSION['id']);

?>

<section aria-describedby="#s1-title" id="app">
    <h3>Bienvenue <?= $user->getUsername() ?></h3>
    <div id="gestion">
        <p>Je souhaite <a href="/deleteAccount">supprimer mon compte</a></p>
        <p>Je souhaite <a href="/">devenir editeur</a></p>
        <p>Je souhaite <a href="/">contacter le support</a></p>
    </div>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
