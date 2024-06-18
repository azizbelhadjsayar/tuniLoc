<?php
    session_start();
    include "config.php";
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs where email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        if(password_verify($motdepasse,$user['motdepasse'])) {
            if($user['statut']!="actif")
                echo json_encode(["message" => "Votre compte est suspendu pour le moment, veuillez contacter notre service client pour le réactiver"]);
            else {
                $_SESSION["id"] = $user['id'];
                $_SESSION["prenom"] = $user['prenom'];
                $_SESSION["nom"] = $user['nom'];
                $_SESSION["email"] = $user['email'];
                $_SESSION["type"] = $user['type'];
                echo json_encode(["message" => "Connexion avec succès","type"=>$user['type']]);
            }
        }
        else {
            echo json_encode(["message" => "Le mot de passe est erroné"]);
        }
    }

    else {
        echo json_encode(["message" => "L'email est erroné"]);
    }
?>