<?php
session_start();
// phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../../vendor/autoload.php';
$phpmailer = new PHPMailer(true); // Passo true per abilitare le eccezioni

require_once __DIR__.'/../connection.php';
require_once __DIR__.'/../functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupero l'email dal form
    $email = $_POST['email'];
// controllo se la mail esiste nel database 
    if(checkMail($email, $conn)){

    // Genero un token 
    $token = bin2hex(random_bytes(32));

    // Salvo il token nel database associato all'email dell'utente
    $hashed_token =  $token;  //password_hash($token, PASSWORD_DEFAULT);
    $sql = "UPDATE utenti SET reset_token = '$hashed_token' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        // Invio un'email all'utente con il link per reimpostare la password
        try {
            // Configuro il server di posta
            $phpmailer->isSMTP(); // Uso SMTP
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io'; // Indirizzo del server SMTP
            $phpmailer->SMTPAuth = true; // Abilito l'autenticazione SMTP
            $phpmailer->Port = 2525; // Porta SMTP del server
            $phpmailer->Username = '92a0a98086ee23'; // Il tuo nome utente SMTP
            $phpmailer->Password = '8608823d32ab74'; // La tua password SMTP
        
            // Configuro mittente e destinatario
            $phpmailer->setFrom('info@edusogno.com', 'Nome Mittente'); // Mittente
            $phpmailer->addAddress($email, 'Nome Destinatario'); // Destinatario
        
            // Contenuto della mail
            $reset_link = "localhost:8888/edusogno/edusogno-esercizio/reset_password_confirm.php?token=$token&email=$email";
            $phpmailer->isHTML(true); // Imposto il formato a HTML
            $phpmailer->Subject = 'Oggetto della mail di prova';
            $phpmailer->Body = "Clicca il seguente link per reimpostare la tua password: <a href=\"$reset_link\">Clicca qui</a><br><br> $reset_link";

        
            // Invia la mail
            $phpmailer->send();
               // Mostro un messaggio di successo all'utente
        
        $_SESSION['success_message'] =  "Ti abbiamo inviato un'email con le istruzioni per reimpostare la password.";
        header("Location: ../../../login.php");
            
        } catch (Exception $e) {
            echo "Errore nell'invio della mail: {$phpmailer->ErrorInfo}";
        }
     
    } else {
        echo "Errore nell'aggiornamento del token nel database: " . $conn->$e->getMessage();
    }
}else{
    $_SESSION['error_message'] = "email non esiste";
            header("Location: ../../../password_modify_request.php");
}
    // Chiudo la connessione al database
    $conn->close();
}
?>