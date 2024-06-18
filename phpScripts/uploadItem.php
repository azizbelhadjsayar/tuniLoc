<?php
    include "config.php";
    include "getnbItems.php";

    try {
        $params = [
            null,
            null,
            null,
            null,
            null,
            $_POST['titre'],
            explode('>', $_POST['categorie'])[0],
            explode('>', $_POST['categorie'])[1],
            $_POST['description'],
            number_format((double)$_POST['prix_jour'],2),
            number_format(((double)$_POST['prix_semaine']/7),2),
            number_format(((double)$_POST['prix_mois']/30),2),
            (double)$_POST['valeur'],
            (double)$_POST['lat'],
            (double)$_POST['lng'],
            (int)$_SESSION['id'],
            $_POST['adresse'],
            ($nbItems+1)
        ];

        $j=1;
        mkdir("../utilisateurs/utilisateur".$_SESSION['id']."/items/item".($nbItems+1));
        for ($i = 1; $i <= 5; $i++) {
            if($_FILES["imgInp".$i]["size"] > 0) {
                $imageName = "imgInp".$i;
                $fileExtension = pathinfo($_FILES[$imageName]["name"], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES[$imageName]["tmp_name"], "../utilisateurs/utilisateur".$_SESSION['id']."/items/item".($nbItems+1)."/image".$j.".".$fileExtension);
                $params[$j-1]="utilisateurs/utilisateur".$_SESSION['id']."/items/item".($nbItems+1)."/image".$j.".".$fileExtension;
                $j++;
            }
        }

        $insert = $conn->prepare("insert into articles (photo1, photo2, photo3, photo4, photo5, titre, categorie, sous_categorie, description, prix_jour, prix_semaine, prix_mois, valeur, lat, lng, proprietaire_id, adresse, id) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") ;
        $insert->execute($params);

        echo 1;
    }
    catch(Exception $e) {
        echo 0;
    }

?>
