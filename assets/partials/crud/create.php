<?php 
    
require_once __DIR__ . '/../../models/Event.php';
require_once __DIR__ . '/../../controller/EvenController.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../../partials/message.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_evento = $_POST['nome_evento'];
    $attendees = $_POST['attendees'];
    $data_evento = $_POST['data_evento'];
    $id_creator = $_POST['id_creator'];
    $description = $_POST['description'];

    $event = new Event(null, $nome_evento, $attendees, $data_evento,$id_creator,$description);

    $controller = new EventController($conn);
    $controller->createEvent($event);
    // Ridirigi verso una pagina di conferma o l'elenco eventi
    $_SESSION['error_message'] = 'L\'evento è stato createo con successo ';
    header("Location: ../../../index.php");
} else {
    // Gestisci il caso in cui il modulo non sia stato inviato
    header("Location: createEvent.php");

}