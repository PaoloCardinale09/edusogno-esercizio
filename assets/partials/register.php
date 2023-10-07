<?php
session_start();
require_once __DIR__.'/connection.php';
require_once __DIR__.'/functions.php';

// unset per svuotare i campi 
unset($_SESSION['name_value']);
unset($_SESSION['surname_value']);
unset($_SESSION['email_value']);

// var_dump($_POST['name']);

// constrollo se i dati in post sono stati passati
if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])){
    
    // Validazione dell'indirizzo email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        saveFormValues($_POST['name'], $_POST['surname'], $_POST['email']);
        $_SESSION['error_message'] = 'L\'indirizzo email non è valido.';
        header("Location: ../../registration.php");
        
        exit();
    }
    // Validazione della password molto semplice
    if (strlen($_POST['password']) < 5) {
        saveFormValues($_POST['name'], $_POST['surname'], $_POST['email']);

        // La password è troppo corta
        $_SESSION['error_message'] = 'La password deve avere almeno 5 caratteri.';
        header("Location: ../../registration.php");
        exit();
    }
    // controllo se la mail è già utilizzata
    if(checkMail($_POST['email'], $conn)) {
        saveFormValues($_POST['name'], $_POST['surname'], $_POST['email']);

        $_SESSION['error_message'] = 'Questa email è già registrata. Per favore, usa un\'altra email.';
        header("Location: ../../registration.php");
         exit(); // termina
    } else {
        register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $conn);
       
        
    }
}else {
    $_SESSION['error_message'] = 'Per favore, compila tutti i campi obbligatori.';
    header("Location: ../../registration.php");
    var_dump($_SESSION);
    exit(); // termina
}

// metodo per recuperare i valori inseriti in caso di registrazione fallita
function saveFormValues($name, $surname, $email) {
    $_SESSION['name_value'] = $name;
    $_SESSION['surname_value'] = $surname;
    $_SESSION['email_value'] = $email;
}

?>