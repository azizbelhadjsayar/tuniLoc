<?php
    session_start();
    include "config.php";
    try {
        $stmt = $conn->prepare("SELECT * FROM articles WHERE proprietaire_id = ?");
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