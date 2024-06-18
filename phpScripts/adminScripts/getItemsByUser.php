<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "../config.php";
    try {
        $results = $conn->query("select * from articles where proprietaire_id =".$_GET['prop_id'])->fetchAll();
        if ($results) {
            echo json_encode($results);
        } else {
            echo "NULL";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>