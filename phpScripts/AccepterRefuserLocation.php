<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $update = $conn->prepare("update locations set statut = ? where id = ?") ;
    $update->execute([$_GET['type'], $_GET['id_location']]);
    echo $_GET['type'];
?>