<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">
    <h2 id="s1-title">Créer un compte:</h2>

    <div id="erreur"><?= WebtoonLike\Site\pageManager\RegisterManager::getErrors() ?></div>

    <form action="/@register" method="post">
        <input type="text" name="username" placeholder="Pseudonyme" required>
        <input type="email" name="email" placeholder="Adresse email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="confirmation_password" placeholder="Répéter le mot de passe" required>
        <input type="submit" value="Connexion">
    </form>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
