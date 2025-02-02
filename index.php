<!DOCTYPE html>
<html lang="en">
<?php include __DIR__.'/assets/partials/head.php'; ?>

<body>
    <?php
 
    include __DIR__.'/assets/partials/header.php';
    include __DIR__.'/assets/partials/connection.php';
    include __DIR__.'/assets/partials/functions.php';

    // controllo se l'utente è loggato
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    // var_dump($_SESSION['user_id'] );
    // var_dump($_SESSION);

    // Richiamo la funzione getEvents e assegno il risultato alla variabile $events
    $events = getUserEvents($conn,$_SESSION['user_id'], $_SESSION['user_email'], );
    ?>
    <section id="events">
        <main>
            <h1>Ciao <span class="username"><?php echo $_SESSION['user_name'] . $_SESSION['user_surname']; ?></span>
                ecco i tuoi eventi</h1>
            <div class="button-wrap">
                <a href="form_create.php" class="crea-evento-button">Crea Evento</a>

                <?php if ($_SESSION['is_admin']): ?>
                <a href="admin_page.php" class="crea-evento-button bg_success">Vai alla Dashboard Admin</a>
            </div>
            <?php endif; ?>

            <div class="events">
                <?php if ($events): ?>
                <?php foreach ($events as $event): ?>
                <div class="event">
                    <h2><a
                            href="event_detail.php?id=<?php echo $event['id']; ?>"><?php echo $event['nome_evento']; ?></a>
                    </h2>
                    <p class="muted-text"><?php echo $event['data_evento']; ?></p>
                    <button><a class="join-button"
                            href="event_detail.php?id=<?php echo $event['id']; ?>">JOIN</a></button>

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