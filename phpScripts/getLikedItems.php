<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    try {
        $results = $conn->query("SELECT e.*, u.*, a.* FROM enregistrements e join articles a on e.id_article = a.id join utilisateurs u on e.id_utilisateur = u.id where a.disponibilite = true and a.statut='accepte' and e.id_utilisateur =".$_SESSION['id']." order by a.date_ajout desc")->fetchAll();
        if ($results) {
            echo json_encode($results);
        } else {
            echo "NULL";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>