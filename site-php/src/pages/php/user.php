<?php require dirname(__DIR__, 2) . '/components/header.php';

$user = \WebtoonLike\Site\controller\UserController::getById($_SESSION['id']);

?>

<section aria-describedby="#s1-title" id="app">
    <h3>Bienvenue <?= $user->getUsername() ?> !</h3>
    <?= WebtoonLike\Site\pageManager\userManager::getErrors() ?>
    <p>Merci de nous faire confiance depuis le <?= $user->getRegisteredAt()->format('j M Y')?>.</p>
    <div id="changeUserInformation">
        <form action="/@changeEmail" method="post" id="changeEmail">
            <label for="email">Votre email:
                <input type="email" name="email" id="email" class='large' value="<?= $user->getEmail() ?>" required>
            </label>
            <input type="submit" value="Changer d'email">
        </form>

        <form action="/@changeUsername" method="post" id="changeUsername">
            <label for="email">Votre pseudonyme:
                <input type="text" name="username" class='large'  id="username" value="<?= $user->getUsername() ?>" required>
            </label>
            <input type="submit" value="Changer de pseudo">
        </form>
    </div>

    <p class="link">Je souhaite <a href="/deleteAccount">supprimer mon compte</a>.</p>
    <p class="link">Je souhaite <a href="/deleteAccount">changer mon mot de passe</a>.</p>


</section>



<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
