<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("update locations set statut='annulee' where id = ? and locataire_id = ?") ;
    $insert->execute([$_GET['location_id'], $_SESSION['id']]);
    echo 1;
?>