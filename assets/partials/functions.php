<?php
function getAllEvents($conn) {
    // Metodo che prende tutti gli eventi
    $sql = "SELECT * FROM eventi";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $events = [];
        while($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        return $events;
    } else {
        return false;
    }
}
function getUserEvents($conn, $user_id, $user_email) {
    // Metodo che prende gli eventi che hanno lo stesso user_id del creatore e quando si è menzionati tra i partecipanti
    $stmt = $conn->prepare("SELECT * FROM eventi WHERE id_creator = ? OR attendees LIKE ? OR attendees LIKE ?");
    
    $user_id_pattern = "$user_id";
    $user_email_pattern = "%,$user_email,%";
    $stmt->bind_param("iss", $user_id, $user_id_pattern, $user_email_pattern);
    
    $stmt->execute();
    $result = $stmt->get_result();

    $events = array();

    while ($row = $result->fetch_assoc()) {
        $events[] = $row; // Aggiungi l'evento all'array
    }

    return $events;
}






function checkMail($email, $conn)
{
  // Metodo che confronta la mail con quelle già  presenti nel DB
  // se trova risultati restituisce true
    $check_stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    return $check_stmt->num_rows > 0;
}

function register($name, $surname, $email, $password, $conn)
{
  // Registra nel DB l'utente
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO `utenti` (`nome`, `cognome`, `email`, `password`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $surname, $email, $hashed_password);

    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = 'La registrazione è andata a buon fine! Reinserisci le tue credenziali per visualizzare i tuoi eventi.';

    header("Location: ../../login.php");
    exit(); // termina
}

// funzione per mandare la mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

function sendEmailToAttendees($subject, $body, $event) {
    $phpmailer= new PHPMailer(true); // Abilita le eccezioni

    try {
        // Configura il server di posta
        $phpmailer->isSMTP(); // Usa SMTP
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io'; // Indirizzo del server SMTP
        $phpmailer->SMTPAuth = true; // Abilita l'autenticazione SMTP
        $phpmailer->Port = 2525; // Porta SMTP del server
        $phpmailer->Username = '92a0a98086ee23'; // Il tuo nome utente SMTP
        $phpmailer->Password = '8608823d32ab74'; // La tua password SMTP

        // Configura mittente
        $phpmailer->setFrom('info@edusogno.com', 'Nome Mittente');

        // Ottieni gli indirizzi email degli attendees dall'evento
        $attendees = preg_split('/[\s,]+/', $event->attendees); // Dividi per spazi o virgole

        foreach ($attendees as $attendee) {
            // Aggiungi ciascun destinatario all'email
            $phpmailer->addAddress(trim($attendee), 'Nome Destinatario');
        }

        // Contenuto dell'email
        $phpmailer->isHTML(true); // Imposta il formato a HTML
        $phpmailer->Subject = $subject; // Oggetto dell'email
        $phpmailer->Body = $body; // Corpo dell'email

        // Invia l'email
        $phpmailer->send();
        return true; // Email inviata con successo
    } catch (Exception $e) {
        return false; // Errore nell'invio dell'email
    }
}