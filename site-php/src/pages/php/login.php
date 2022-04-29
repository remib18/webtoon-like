<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">

    <h2 id="s1-title">Connexion au site web:</h2>
    <?= WebtoonLike\Site\pageManager\LoginManager::getErrors() ?>
    <hr>

    <form action="/@login" method="post" required>
        <input type="email" name="email" placeholder="Adresse email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Connexion">
    </form>

    <p id="register-link">Non-inscrit? Consultez la <a href="/register">page d'inscription</a>.</p>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
