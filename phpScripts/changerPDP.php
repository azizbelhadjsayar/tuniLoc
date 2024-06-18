<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";


    function supprimerToutesLesImages($chemin_dossier) {
        $modele_fichier = $chemin_dossier . '*.{jpg,jpeg,png,gif}';
        $images = glob($modele_fichier, GLOB_BRACE);
        if ($images !== false && count($images) > 0) {
            foreach ($images as $image) 
                unlink($image);
        }
    }

    try {
        if(isset($_FILES["image"])) {
            if($_FILES["image"]["size"] > 0) {
                supprimerToutesLesImages("../utilisateurs/utilisateur".$_SESSION['id']."/pdp/");
                $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $filePath = "utilisateurs/utilisateur".$_SESSION['id']."/pdp/profile.".$fileExtension;
                if(move_uploaded_file($_FILES["image"]["tmp_name"], "../".$filePath)){
                    $insert = $conn->prepare("UPDATE utilisateurs set photo_profil = ? where id = ?");
                    $insert->execute([$filePath,$_SESSION['id']]);
                    echo $filePath;
                }
        } else {
            echo "Error uploading image!";
        }
    }
    } catch(Exception $e) {
        echo 'NULL';
    }

?>