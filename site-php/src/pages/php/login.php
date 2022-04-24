<?php require dirname(__DIR__, 2) . '/components/header.php'; ?>

<section aria-describedby="#s1-title" id="app" xmlns:input="http://www.w3.org/1999/html">
    <h2 id="s1-title">Login</h2>
    <form action="/@login" method="post">
        <input type="email" name="email">
        <input type="password" name="password">
        <input type="submit" value="Connexion">
    </form>
</section>

<?php require dirname(__DIR__, 2) . '/components/footer.php'; ?>
