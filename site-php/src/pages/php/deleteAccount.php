<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">

    <h2 id="s1-title">Supprimer votre compte:</h2>
    <?= WebtoonLike\Site\pageManager\deleteAccountManager::getErrors() ?>
    <hr>

    <form action="/@deleteAccount" method="post">
        <p id="suppressionWarning">
            Vos contributions ne seront pas supprimées,
            mais les données associées vous y liant le seront.
        </p>
        <br>
        <label for="password">Validez votre mot de passe:
            <input type="password" name="password" id="password" placeholder="mon mot de passe" required>
        </label>

        <label for="deleteAccount">Je comprend que cette operation est irreversible
            <input type="checkbox" name="deleteAccount" id="deleteAccount">
        </label>

        <input type="submit" value="Supprimer mon compte.">
    </form>

</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
