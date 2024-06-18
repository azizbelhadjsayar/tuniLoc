<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("insert into enregistrements (id_article, id_utilisateur) values (?, ?)") ;
    $insert->execute([$_GET['id_article'], $_SESSION['id']]);
    echo 1;
?>