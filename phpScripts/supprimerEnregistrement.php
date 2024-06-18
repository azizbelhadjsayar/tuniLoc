<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("delete from enregistrements where id_article = ? and id_utilisateur = ?") ;
    $insert->execute([$_GET['id_article'], $_SESSION['id']]);
    echo 1;
?>