<?php
  // definizione delle costanti per la connessione al database
  const DB_SERVER = "localhost";
  const DB_USERNAME = "root";
  const DB_PASSWORD = "root";
  const DB_NAME = "users";
 

  // tentativo di connessione al database MySQL
  try{
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  }catch(Exception $e){
    echo "Connection failed: ". $e->getMessage();
    exit;

  }
?>