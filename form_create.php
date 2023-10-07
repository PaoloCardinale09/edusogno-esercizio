<!DOCTYPE html>
<html lang="en">
<?php include './assets/partials/head.php'; ?>

<body>
    <?php
    include_once __DIR__.'/assets/partials/header.php';
    include_once __DIR__ . '/assets/models/Event.php';
    include_once __DIR__.'/assets/controller/EvenController.php';
    $controller = new EventController($conn);

    // Controllo se utente è loggato
    if (!isset($_SESSION['user_id'])) { 
        // Se l'utente non è loggato, reindirizzo alla pagina di login 
        header("Location: login.php");
        exit();}
    ?>
    <h1>Crea nuovo evento </h1>
    <div class="button-wrap">
        <a href="index.php" class="crea-evento-button">Torna indietro</a>
    </div>
    <?php include './assets/partials/message.php' ?>
    <section class="form">
        <div class="login-form">
            <form method="POST" action="./assets/partials/crud/create.php">
                <input type="hidden" name="id_creator" value="<?php echo $_SESSION['user_id']; ?>">
                <label for="nome_evento">Inserisci il titolo:</label>
                <input type="text" id="nome_evento" name="nome_evento" placeholder="Title">

                <label for="description">Inserisci la descrizione:</label>
                <input type="text" id="description" name="description" placeholder="Title">

                <label for="attendees">Inserisci i partecipanti:</label>
                <input type="text" id="attendees" name="attendees" placeholder="Attendees">

                <label for="data_evento">Inserisci la data:</label>
                <input type="datetime-local" id="data_evento" name="data_evento" placeholder="Date">


                <input type="submit" value="CREA">
            </form>

        </div>
    </section>
</body>

</html>