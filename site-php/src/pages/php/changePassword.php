<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app">

    <h2 id="s1-title">Changer votre mot de passe:</h2>
    <?= WebtoonLike\Site\pageManager\MessageManager::getErrors() ?>
    <?= WebtoonLike\Site\pageManager\MessageManager::getMessages() ?>
    <hr>

    <form action="/@changePassword" method="post">
        <label for="password">Quel est votre mot de passe actuel?
            <input type="password" name="password" id="password" placeholder="Mon mot de passe" required
                   class="large">
        </label>

        <label for="new_password">Saisissez un nouveau mot de passe
            <input type="password" name="new_password" class="large"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="Doit contenir au moins un chiffre, une majuscule, une minuscule et doit être d'au minimum 8 caractères."
                   id="new_password">
        </label>

        <label for="confirmation_new_password">Validez votre nouveau mot de passe
            <input type="password" name="confirmation_new_password" class="large" id="confirmation_new_password">
        </label>

        <input type="submit" value="Changer de mot de passe">
        <button type="button" onclick="window.location.href='/user';">Annuler</button>
    </form>

</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
