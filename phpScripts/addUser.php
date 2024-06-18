<?php
    session_start();
    include "config.php";
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $motdepasse = $_POST['motdepasse'];
    $confirmermotdepasse = $_POST['confirmermotdepasse'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs where email=?");
    $stmt->execute([$email]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) echo json_encode(["message" => "L'email existe deja"]);
    else {
        $stmt = $conn->prepare("SELECT * FROM utilisateurs where telephone=?");
        $stmt->execute([$telephone]);
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) echo json_encode(["message" => "Le numéro de téléphone existe deja"]);

        elseif($confirmermotdepasse!=$motdepasse) echo json_encode(["message" => "Veuillez confirmer votre mot de passe"]);

        elseif(($confirmermotdepasse==$motdepasse)&&(strlen($motdepasse)<8)) echo json_encode(["message" => "Le mot de passe doit contenir au moins 8 caractères"]);
        else {
            $insert = $conn->prepare("insert into utilisateurs(prenom, nom, email, telephone, motdepasse, photo_profil) values(?, ?, ?, ?, ?, ?)") ;
            $insert->execute([$prenom, $nom, $email, $telephone, password_hash($motdepasse, PASSWORD_DEFAULT), "images/camera.png"]);
            $_SESSION["id"] = $conn->lastInsertId();
            $_SESSION["prenom"] = $prenom;
            $_SESSION["nom"] = $nom;
            $_SESSION["email"] = $email;
            $_SESSION["type"] = "user";
            $userFolder = "../utilisateurs/utilisateur".$conn->lastInsertId();
            mkdir($userFolder);

            $filePath =$userFolder."/infos.txt";
            $fileHandle = fopen($filePath, 'w');
            fwrite($fileHandle, "prenom : $prenom\nnom : $nom\nemail : $email\ntelephone : $telephone");
            fclose($fileHandle);

            mkdir($userFolder."/items");
            mkdir($userFolder."/pdp");

            echo json_encode(["message" => "Utilisateur est ajouté avec succès", "id"=>$_SESSION['id'], "prenom"=>$_SESSION['prenom'], "nom"=>$_SESSION['nom'], "email"=>$_SESSION['email']]);
        }
    }
?>