<!DOCTYPE html>
<html lang="en">
<?php include __DIR__.'/assets/partials/head.php'; ?>

<body>
    <?php
 
    include __DIR__.'/assets/partials/header.php';
    include __DIR__.'/assets/partials/connection.php';
    include __DIR__.'/assets/partials/functions.php';

    // controllo se c'è nella sessione id e se l'utente è amministratore
    if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != true) {
        header("Location: index.php");
        exit;
    }

    // var_dump($_SESSION['is_admin']);
    // var_dump($_SESSION);

    // Richiamo la funzione getEvents e assegno il risultato alla variabile $events
    $events = getAllEvents($conn);
    ?>
    <section id="events">
        <main>
            <h1> <span class="alert">ADMIN PAGE </span> <br> Ecco tutti gli eventi </h1>
            <div class="button-wrap">
                <a href="form_create.php" class="crea-evento-button">Crea Evento</a>

                <a href="index.php" class="crea-evento-button">Torna indietro</a>
            </div>


            <div class="events">
                <?php if ($events): ?>
                <?php foreach ($events as $event): ?>
                <div class="event">
                    <h2><a
                            href="event_detail.php?id=<?php echo $event['id']; ?>"><?php echo $event['nome_evento']; ?></a>
                    </h2>
                    <p class="muted-text"><?php echo $event['data_evento']; ?></p>

                    <button><a class="join-button"
                            href="event_detail.php?id=<?php echo $event['id']; ?>">MODIFICA</a></button>
                </div>
                <?php endforeach; ?>


                <?php else: ?>
                <p>Nessun evento trovato.</p>
                <?php endif; ?>
            </div>
        </main>
    </section>

</body>

</html>