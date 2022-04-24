<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">
    <h2 id="s1-title">Register</h2>
    <form action="/@register" method="post">
        <input type="text" name="username">
        <input type="email" name="email">
        <input type="password" name="password">
        <input type="password" name="confirmation_password">
        <input type="submit" value="Connexion">
    </form>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
