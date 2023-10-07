<?php
session_start();

// Controllo se l'indirizzo email è presente nell'url
if(isset($_GET['email']) && isset($_GET['token'])) {
    // Recupera l'indirizzo email e il token dall' url
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Memorizza l'indirizzo email nella variabile di sessione
    $_SESSION['email'] = $email;
    $_SESSION['token'] = $token;
} else {
    // Se l'indirizzo email non è presente 
    $_SESSION['error_message'] = "Indirizzo email non fornito nella query string.";
    header("Location: pagina_errore.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php include './assets/partials/header.php'; ?>
    <h1>Inserisci la nuova password</h1>
    <!-- Mostra il messaggio di errore/successo se presente -->
    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form method="POST" action="./assets/partials/password/change_password.php">
                <label for="new-password">Nuova password:</label>
                <input type="password" id="new-password" name="new-password" placeholder="Scrivila qui" required>
                <div class="password-toggle">
                    <label for="confirm-password">Conferma password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Scrivila Qui"
                        required>
                </div>
                <input type="submit" value="INVIA">
            </form>

            <div class="form-actions">
                <a href="registration.php">Non hai ancora un profilo? <strong><u>Registrati</u></strong></a>
            </div>
        </div>
    </section>
</body>

</html>


<!-- Metodo per controllare se le 2 password coincidono -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const newPasswordInput = document.getElementById("new-password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const submitButton = document.querySelector("form");

    function validatePassword() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const passwordsMatch = newPassword === confirmPassword;

        if (passwordsMatch) {
            confirmPasswordInput.setCustomValidity("");
        } else {
            confirmPasswordInput.setCustomValidity("Le password non corrispondono");
        }
    }

    newPasswordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validatePassword);

    submitButton.addEventListener("submit", function(event) {
        if (!confirmPasswordInput.validity.valid) {
            event.preventDefault();
        }
    });
});
</script>