s<?php
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../partials/connection.php';
require_once __DIR__ . '/../partials/message.php';
require_once __DIR__ . '/../partials/functions.php';

class EventController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

 
    public function createEvent(Event $event) {
      
        // inserisco nel DB un nuovo evento 
        $stmt = $this->conn->prepare("INSERT INTO eventi (nome_evento, attendees, data_evento, id_creator, description) VALUES (?, ?, ?, ?,?)");
        $stmt->bind_param("sssis", $event->nome_evento, $event->attendees, $event->data_evento, $event->id_creator, $event->description);
    
        if ($stmt->execute()) {
           // Formatta la data e l'ora
            $dataFormattata = date('d/m/Y', strtotime($event->data_evento));
            $oraFormattata = date('H:i', strtotime($event->data_evento));
            $dataOraFormattata = $dataFormattata .' alle '. $oraFormattata;
            // imposto i dati
            $subject = 'Nuovo evento creato';
            $body = 'E\' stato creato un nuovo evento in cui sei partecipante <br> Nome evento:  <strong>' . $event->nome_evento . '</strong> 
            <br>Data e ora: <strong>' . $dataOraFormattata.'</strong>' ;
            // uso la funzione sendEmailToAttendees per mandare una mail a tutte le persone che sono tra i partecipanti
            sendEmailToAttendees($subject, $body, $event) ;

            $_SESSION['success_message'] =  "Evento creato con successo";
            return true; // Evento creato con successo
        } else {
            $_SESSION['error_message'] =  "Errore nella creazioen dell' evento";

            return false; // Errore nella creazione dell'evento
        }
    }
    
  

    public function updateEvent(Event $event) {
        // aggiorno il DB
        $stmt = $this->conn->prepare("UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?");
        $stmt->bind_param("sssi", $event->nome_evento, $event->attendees, $event->data_evento, $event->id);
    
        if ($stmt->execute()) {
             // Formatta la data e l'ora
             $dataFormattata = date('d/m/Y', strtotime($event->data_evento));
             $oraFormattata = date('H:i', strtotime($event->data_evento));
             $dataOraFormattata = $dataFormattata .' alle '. $oraFormattata;
            // imposto i dati
             $subject = 'Evento modificato';
             $body = 'E\' stato modificato un nuovo evento in cui sei partecipante <br> Nome evento:  <strong>' . $event->nome_evento . '</strong> 
             <br>Data e ora: <strong>' . $dataOraFormattata.'</strong>' ;
                   // uso la funzione sendEmailToAttendees per mandare una mail a tutte le persone che sono tra i partecipanti
             sendEmailToAttendees($subject, $body, $event) ;

            $_SESSION['success_message'] =  "Evento aggiornato con successo";
   
            return true; // Evento aggiornato con successo
        } else {
            $_SESSION['error_message'] =  "Errore nell' aggiornamento";
            
        }
    }
    
    

    public function getEventById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM eventi WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Restituisci i dati dell'evento
        } else {
            return null; // Nessun evento trovato con questo ID
        }
    }


    public function deleteEvent($id) {
        $stmt = $this->conn->prepare("DELETE FROM eventi WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true; // Evento eliminato con successo
        } else {
            return false; // Errore nella cancellazione dell'evento
        }
    }

    public function getAllEvents() {
        // seleziono tutti gli eventi nel database(per amministratore)
        $sql = "SELECT * FROM eventi";
        $result = $this->conn->query($sql);

        $events = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $events[] = $row; // Aggiungi l'evento all'array
            }
        }

        return $events;
    }
}