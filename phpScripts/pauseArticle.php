<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("update articles set disponibilite = false where id = ?") ;
    $insert->execute([$_GET['id']]);
    echo 1;
?>