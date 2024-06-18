<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "../config.php";
    try {
        $results = $conn->query("SELECT u.*, count(a.id) as nbItems from articles a right join utilisateurs u on a.proprietaire_id = u.id group by u.id having u.type='user'")->fetchAll();
        if ($results) {
            echo json_encode($results);
        } else {
            echo "NULL";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>