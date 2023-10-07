<?php
session_start();
require_once __DIR__.'/../connection.php';
require_once __DIR__.'/../functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera l'email dal form
    $email = $_POST['email'];
// controllo se la mail esiste nel database 
    if(checkMail($email, $conn)){

    // Genera un token
    $token = bin2hex(random_bytes(32));

    // Salva il token nel database associato all'email dell'utente
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);
    $sql = "UPDATE utenti SET reset_token = '$hashed_token' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        // Invia un'email all'utente con il link per reimpostare la password
        $reset_link = "localhost/reset_password_confirm.php?token=$token&email=$email";
        $to = $email;
        $subject = "Password Reset";
        $message = "Clicca il seguente link per reimpostare la tua password: $reset_link";
        $headers = "From: info@edusogno.com";

        // Invia l'email
        mail($to, $subject, $message, $headers);

        // Mostra un messaggio di successo all'utente
        
        $_SESSION['success_message'] =  "Ti abbiamo inviato un'email con le istruzioni per reimpostare la password.";
        header("Location: ../../../login.php");
    } else {
        echo "Errore nell'aggiornamento del token nel database: " . $conn->$e->getMessage();
    }
}else{
    $_SESSION['error_message'] = "email non esiste";
            header("Location: ../../../password_modify_request.php");
}
    // Chiudi la connessione al database
    $conn->close();
}
?>