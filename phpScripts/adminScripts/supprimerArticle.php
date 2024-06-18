<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "../config.php";
    function supprimerDossierEtContenu($chemin) {
        if (!is_dir($chemin)) {
            return false;
        }

        $contenu = scandir($chemin);
        foreach ($contenu as $fichier) {
            if ($fichier != '.' && $fichier != '..') {
                $fichierComplet = $chemin . '/' . $fichier;
                if (is_dir($fichierComplet)) {
                    supprimerDossierEtContenu($fichierComplet);
                } else {
                    unlink($fichierComplet);
                }
            }
        }

        return rmdir($chemin);
    }
    
    try {
        $insert = $conn->prepare("delete from articles where id = ?") ;
        $insert->execute([$_GET['id']]);
        supprimerDossierEtContenu("../../utilisateurs/utilisateur".$_GET['userid']."/items/item".$_GET['id']);
        echo "L'article est supprimé avec succès !";
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>


