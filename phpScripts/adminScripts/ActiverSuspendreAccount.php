<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "../config.php";
    try {
        $insert = $conn->prepare("update utilisateurs set statut = ? where id = ?") ;
        $insert->execute([$_GET['statut'], $_GET['id']]);
        if($_GET['statut']=="actif")
            echo "Le compte est devenu activé";
        else
            echo "Le compte est devenu suspendu";
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>