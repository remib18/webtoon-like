<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">

    <h2 id="s1-title">Créer un compte:</h2>
    <?= WebtoonLike\Site\pageManager\RegisterManager::getErrors() ?>
    <hr>

    <form action="/@register" method="post">

        <label for="email">Choisissez un nom d'utilisateur:
            <input type="text" name="username" id="username" placeholder="Pseudonyme" required>
        </label>

        <label for="email">Entre votre adresse email:
            <input type="email" name="email" id="email" placeholder="Adresse email" required>
        </label>

        <label for="email">Choisissez un mot de passe:
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        </label>

        <label for="email">Répéter  le mot de passe:
            <input type="password" name="confirmation_password" id="confirmation_password" placeholder="Répéter le mot de passe" required>
        </label>

        <input type="submit" value="Connexion">
    </form>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
