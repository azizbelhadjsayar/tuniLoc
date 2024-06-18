<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    try {
        $stmt = $conn->prepare("SELECT id_article FROM enregistrements WHERE id_utilisateur = ?");
        $stmt->execute([(int)$_SESSION['id']]);
        $results = $stmt->fetchAll();
        if ($results) {
            echo json_encode($results);
        } else {
            echo "NULL";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>