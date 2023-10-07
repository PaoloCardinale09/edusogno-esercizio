<?php
// controllo se ho i dati in post
if (isset($_POST['email']) && isset($_POST['password'])) {
session_start();
include __DIR__.'/connection.php';
// uso la funzione login
login($_POST['email'], $_POST['password'], $conn);
} else {
header("Location: ../../login.php");
session_destroy();
}

function login($email, $password, $conn)
{
    // selezione i dati dell'utente in base alla mail 
$stmt = $conn->prepare("SELECT `id`, `nome`, `cognome`, `password`,`is_admin` FROM `utenti` WHERE `email` = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// se ci sono risultati faccio la verifica della password 
if ($result->num_rows > 0) {
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
    // metto i dati in sessione
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nome'];
$_SESSION['user_surname'] = $user['cognome'];
$_SESSION['user_email'] = $email;
$_SESSION['is_admin'] = $user['is_admin'];

// reindirizzo
header("Location: ../../index.php");
} else {
$_SESSION['error_message'] = 'La password inserita è errata.';
header("Location: ../../login.php");
}
} else {
$_SESSION['error_message'] = 'Nessun utente trovato con questa email.';
header("Location: ../../login.php");
}

$stmt->close();
}
?>