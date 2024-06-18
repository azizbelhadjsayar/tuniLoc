<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";

    try {
        $dateDebut = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_debut'])));
        $dateFin = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_fin'])));
        $insert = $conn->prepare("INSERT INTO locations (article_id, proprietaire_id, locataire_id, statut, demande_message, jours, montant_total, date_debut, date_fin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$_GET['article_id'], $_GET['proprietaire_id'], $_GET['locataire_id'], 'enattente', $_GET['demande_message'], $_GET['jours'], $_GET['montant'], $dateDebut, $dateFin]);
        echo "1"; // Succès
    } catch(Exception $e) {
        echo "Erreur : " . $e->getMessage(); // Erreur
    }
?>