<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">

    <h2 id="s1-title">Créer un compte:</h2>
    <?= WebtoonLike\Site\pageManager\RegisterManager::getErrors() ?>
    <hr>

    <form action="/@register" method="post">

        <label for="username">Choisissez un nom d'utilisateur:
            <input type="text"
                   name="username" id="username"
                   placeholder="J0hn_Doe"
                   pattern="^[a-zA-Z0-9_\-]{3,32}$"
                   title="Votre pseudo doit contenir entre 3 et 32 characters alphanumérique, underscore et tirets autorisés."
                   autocomplete="off",
                   class = 'large'
                   required>
        </label>

        <label for="email">Entre votre adresse email:
            <input type="email"
                   name="email" id="email"
                   placeholder="john.doe@deer.bleat"
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                   title="Entrez un email valid."
                   autocomplete="on"
                   class = 'large'
                   required>
        </label>

        <label for="password">Choisissez un mot de passe:
            <input type="password"
                   name="password" id="password"
                   placeholder="Mot de passe (fort si possible)"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="Doit contenir au moins un chiffre, une majuscule, une minuscule et doit être d'au minimum 8 caractères."
                   autocomplete="on"
                   class = 'large'
                   required>
        </label>

        <label for="confirmation_password">Répéter  le mot de passe:
            <input type="password"
                   name="confirmation_password" id="confirmation_password"
                   placeholder="Répéter le mot de passe"
                   autocomplete="off"
                   class = 'large'
                   required>
        </label>

        <input type="submit" value="Connexion">
    </form>
</section>

<script>
    signon.autofillForms = false
</script>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
