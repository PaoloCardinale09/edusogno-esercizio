<?php
session_start();
require_once __DIR__.'/../../controller/EvenController.php';

// Verifica se l'utente è autenticato e ha i privilegi necessari
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $eventController = new EventController($conn);

    // Ottieni l'ID dell'evento dalla richiesta GET
    $event_id = $_GET['id'];

    // Chiamata alla funzione deleteEvent
    if ($eventController->deleteEvent($event_id)) {
        // Evento eliminato con successo, puoi reindirizzare l'utente a una pagina di conferma o altrove
        header("Location: ../../../index.php");
        exit;
    } else {
        // Errore durante l'eliminazione dell'evento
        echo "Errore durante l'eliminazione dell'evento.";
    }
} else {
    // L'utente non è autenticato o non ha i privilegi necessari
    echo "Accesso non autorizzato.";
}
?>