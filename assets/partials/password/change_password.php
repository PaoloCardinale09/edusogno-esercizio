<?php
session_start();

require_once __DIR__.'/../connection.php';
require_once __DIR__.'/../message.php';

if(isset($_SESSION['token']) && isset($_SESSION['email']) && !empty($_SESSION['token']) && !empty($_SESSION['email'])) { 
    // Verifico se il token nell'URL corrisponde a quello nel database

    $token_from_url = $_SESSION['token'];
    $email_from_url = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT reset_token FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email_from_url);
    $stmt->execute();
    $stmt->bind_result($token_from_db);
    $stmt->fetch();
    $stmt->close();

    if ($token_from_url === $token_from_db) {
        // Il token è valido, consento all'utente di reimpostare la password

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recupero la nuova password inviata dal form
            $newPassword = $_POST['new-password'];

            // Hashing della nuova password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Aggiorno la password nel database per l'utente autenticato
            $stmt = $conn->prepare("UPDATE utenti SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $email_from_url);
            if ($stmt->execute()) {
                // Password aggiornata con successo
                $_SESSION['success_message'] = "La tua password è stata cambiata con successo. Fai il login";
                // Cancello il reset_token dal database
                $stmt = $conn->prepare("UPDATE utenti SET reset_token = NULL WHERE email = ?");
                $stmt->bind_param("s", $email_from_url);
                if ($stmt->execute()) {
                    // reset_token cancellato con successo
                } else {
                    // Errore nella cancellazione del reset_token
                    $_SESSION['error_message'] = "Errore nella cancellazione del reset_token";
                }
            } else {
                // Errore nell'aggiornamento della password
                $_SESSION['error_message'] = "Errore nell'aggiornamento della password";
            }

            // Chiudi la connessione al database
            $stmt->close();
        }
        
        header("Location: ../../../login.php");
    } else {
        // Il token non è valido, mostro un messaggio di errore 
        $_SESSION['error_message'] = "Qualcosa è andato storto, Riprova!";
        header("Location: ../../../login.php");
    }
} else {
    $_SESSION['error_message'] = "Ho riscontrato dei problemi, inserisci nuovamente la tua e-mail";
    header("Location: ../../../password_modify_request.php");
}
?>