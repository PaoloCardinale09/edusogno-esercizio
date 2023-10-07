<?php
include __DIR__.'/assets/partials/head.php';
include __DIR__.'/assets/partials/header.php';
include __DIR__.'/assets/partials/connection.php';
include __DIR__.'/assets/partials/functions.php';
include __DIR__.'/assets/controller/EvenController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Assicurati che l'ID dell'evento sia passato nella query string dell'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = $_GET['id'];
    $eventController = new EventController($conn);
    $event = $eventController->getEventById($eventId);
} else {
    // id non valido reindirizzo 
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <section id="event-details">
        <main class="">
            <?php if ($event): ?>
            <h1>Dettagli dell'evento <?php echo htmlspecialchars($event['nome_evento']); ?></h1>
            <div class="button-wrap">
                <a href="index.php" class="crea-evento-button">Torna indietro</a>
            </div>

            <table>
                <tr>
                    <th>Nome Evento: </th>
                    <td><?php echo htmlspecialchars($event['nome_evento']); ?></td>
                </tr>
                <tr>
                    <th>Descrizione: </th>
                    <td><?php echo htmlspecialchars($event['description']); ?></td>
                </tr>
                <tr>
                    <th>Data e ora dell'evento: </th>
                    <td><?php echo htmlspecialchars($event['data_evento']); ?></td>
                </tr>
                <tr>
                    <th>Partecipanti:</th>
                    <td><?php echo htmlspecialchars($event['attendees']); ?></td>
                </tr>
                <tr>
                    <th>id evento:</th>
                    <td><?php echo htmlspecialchars($event['id']); ?></td>
                </tr>
                <tr>
                    <th>id creatore dell' evento:</th>
                    <td><?php echo htmlspecialchars($event['id_creator']); ?></td>
                </tr>


                <tr>
                    <td class="actions" colspan="2">
                        <a class="detail_button white"
                            href="form_update.php?id=<?php echo $event['id']; ?>">Modifica</a>
                        <button class="detail_button bg_alert"
                            onclick="confirmDelete(<?php echo $event['id']; ?>)">Cancella</button>
                    </td>

                </tr>
            </table>

            <?php else: ?>
            <p>Evento non trovato.</p>
            <?php endif; ?>
        </main>
    </section>
</body>

</html>


<!-- script di sicurezza prima di eliminare -->
<script>
function confirmDelete(eventId) {
    var confirmDelete = confirm("Sei sicuro di voler cancellare questo evento?");
    if (confirmDelete) {
        window.location.href = "./assets/partials/crud/delete.php?id=" + eventId;
    }
}
</script>