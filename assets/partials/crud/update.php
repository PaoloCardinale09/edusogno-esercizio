<?php 
require_once __DIR__ . '/../../models/Event.php';
require_once __DIR__ . '/../../controller/EvenController.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../../partials/message.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['event_id']; // Ottieni l'id dell'evento che desideri aggiornare
    $nome_evento = $_POST['nome_evento'];
    $attendees = $_POST['attendees'];
    $data_evento = $_POST['data_evento'];
    $id_creator = $_POST['id_creator'];
    $description = $_POST['description'];


    // Crea un nuovo oggetto Event con i dati ricevuti
    $event = new Event($id, $nome_evento, $attendees, $data_evento,$id_creator, $description);

    // Inizializza il controller dell'evento
    $controller = new EventController($conn);

    // Esegui l'aggiornamento dell'evento
    if ($controller->updateEvent($event)) {
        // Evento aggiornato con successo, reindirizza all'elenco degli eventi
        $_SESSION['success_message'] = 'L\'evento è stato aggiornato con successo';
        header("Location: ../../../index.php");
    } else {
        // Errore nell'aggiornamento dell'evento
        $_SESSION['error_message'] = 'Errore nell\'aggiornamento dell\'evento. Si prega di riprovare.';
        header("Location: editEvent.php?id=$id"); // Reindirizza nuovamente alla pagina di modifica con l'id dell'evento
    }
} else {
    // Gestisci il caso in cui il modulo non sia stato inviato
    header("Location: createEvent.php");
}
?>