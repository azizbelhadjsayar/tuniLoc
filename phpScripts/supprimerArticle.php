<?php
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

    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("delete from articles where id = ?") ;
    $insert->execute([$_GET['id']]);
    supprimerDossierEtContenu("../utilisateurs/utilisateur".$_SESSION['id']."/items/item".$_GET['id']);
    echo 1;
?>