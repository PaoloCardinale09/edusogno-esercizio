<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php
    include __DIR__.'/assets/partials/header.php';

    // Assicurati che l'utente sia loggato
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    include_once __DIR__.'/assets/controller/EvenController.php';
    include_once __DIR__.'/assets/models/Event.php';
    include_once __DIR__.'/assets/partials/connection.php';

    $controller = new EventController($conn);

    // Recupero l'evento dall'id passato nella URL
    if (isset($_GET['id'])) {
        $eventId = $_GET['id'];
        $event = $controller->getEventById($eventId);

        // Controllo che l'evento esista
        if (!$event) {
            die("Evento non trovato.");
        }
    } else {
        // Caso in cui non è stato fornito un id valido
        die("ID dell'evento non fornito.");
    }
    ?>

    <h1>Modifica evento: <?php echo htmlspecialchars($event['nome_evento'])?></h1>
    <div class="button-wrap">
        <a href="index.php" class="crea-evento-button">Torna indietro</a>
    </div>

    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form method="POST" action="./assets/partials/crud/update.php">


                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <label for="nome_evento">Titolo:</label>
                <input type="text" id="nome_evento" name="nome_evento"
                    value="<?php echo htmlspecialchars($event['nome_evento']); ?>" required>
                <label for="description">Descrizione evento:</label>
                <input type="text" id="description" name="description"
                    value="<?php echo htmlspecialchars($event['description']); ?>" required>

                <label for="attendees">Partecipanti:</label>
                <input type="text" id="attendees" name="attendees"
                    value="<?php echo htmlspecialchars($event['attendees']); ?>" required>

                <label for="data_evento">Data:</label>
                <input type="datetime-local" id="data_evento" name="data_evento"
                    value="<?php echo $event['data_evento']; ?>" required>

                <input type="submit" value="Aggiorna">
            </form>
        </div>
    </section>
</body>

</html>