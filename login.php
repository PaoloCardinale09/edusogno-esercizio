<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php include './assets/partials/header.php'; ?>
    <h1>Hai già un account?</h1>
    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form method="POST" action="./assets/partials/process-login.php">
                <label for="email">Inserisci l&apos;e-mail:</label>
                <input type="text" id="email" name="email" placeholder="name@example.com" required>
                <div class="password-toggle">
                    <label for="password">Inserisci la password:</label>
                    <input type="password" id="password" name="password" placeholder="Scrivila Qui" required>
                    <button type="button" onclick="togglePassword()">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <input type="submit" value="ACCEDI">
            </form>

            <div class="actions">
                <div class="recover-wrap">
                    <a class="recover" href="password_modify_request.php">Reimposta password</a>
                </div>
                <a href="registration.php">Non hai ancora un profilo? <strong><u>Registrati</u></strong></a>
            </div>
        </div>
    </section>
</body>

</html>