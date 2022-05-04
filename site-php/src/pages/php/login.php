<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">

    <h2 id="s1-title">Connexion au site web:</h2>
    <?= WebtoonLike\Site\pageManager\LoginManager::getErrors() ?>
    <hr>

    <form action="/@login" method="post">
        <label for="email">Votre email:
            <input type="email" name="email" id="email" class='large' placeholder="Adresse email" required>
        </label>

        <label for="password">Votre mot de pass:
            <input type="password" name="password" class='large'  id="password" placeholder="Mot de passe" required>
        </label>

        <label for="rememberMe">Rester connecter
            <input type="checkbox" name="rememberMe" class='large'  id="rememberMe">
        </label>

        <input type="submit" value="Connexion">

    </form>

    <p id="register-link">Non-inscrit? Consultez la <a href="/register">page d'inscription</a>.</p>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
