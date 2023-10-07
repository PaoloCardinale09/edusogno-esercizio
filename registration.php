<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php
    include './assets/partials/header.php';
    // include './assets/partials/config.php';
    ?>
    <h1>Registra qui il tuo Account</h1>
    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form method="POST" action="./assets/partials/register.php">
                <label for="name">Inserisci il Nome:</label>
                <input type="text" id="name" name="name" placeholder="Mario"
                    value="<?php echo isset($_SESSION['name_value']) ? htmlspecialchars($_SESSION['name_value']) : ''; ?>">

                <label for="surname">Inserisci il Cognome:</label>
                <input type="text" id="surname" name="surname" placeholder="Rossi"
                    value="<?php echo isset($_SESSION['surname_value']) ? htmlspecialchars($_SESSION['surname_value']) : ''; ?>">
                <label for="email">Inserisci l&apos;e-mail:</label>
                <input type="text" id="email" name="email" placeholder="name@example.com"
                    value="<?php echo isset($_SESSION['email_value']) ? htmlspecialchars($_SESSION['email_value']) : ''; ?>">
                <div class="password-toggle">
                    <label for="password">Inserisci la password:</label>
                    <input type="password" id="password" name="password" placeholder="Scrivila Qui">
                    <button type="button" onclick="togglePassword()">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <input type="submit" value="REGISTRATI">
            </form>
            <div class="actions">
                <a href="login.php">Hai già un Account? <strong><u>Accedi</u></strong></a>
            </div>
        </div>
    </section>
</body>

</html>