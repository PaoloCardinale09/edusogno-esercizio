<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php include './assets/partials/header.php'; ?>
    <h1>Modifica password </h1>
    <!-- Mostra il messaggio di errore/successo se presente -->
    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form action="./assets/partials/password/process_modify_password.php" method="POST">
                <label for="email">Inserisci l&apos;e-mail associata al tuo account:</label>
                <input type="text" id="email" name="email" placeholder="Inserisci qui la tua e-mail" required>
                <input type="submit" value="Conferma ed Invia">
            </form>
        </div>
    </section>
</body>

</html>