<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    try {
        $results = $conn->query("SELECT a.*, u.prenom, u.nom FROM articles a join utilisateurs u on a.proprietaire_id = u.id where a.disponibilite = true and a.statut='accepte' and (a.titre like '%".$_GET['titre']."%' or u.prenom like '%".$_GET['titre']."%' or a.adresse like '%".$_GET['titre']."%') order by a.date_ajout desc")->fetchAll();
        if ($results) {
            echo json_encode($results);
        } else {
            echo "NULL";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>