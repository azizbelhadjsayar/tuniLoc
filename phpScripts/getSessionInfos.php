<?php
    session_start();
    if(isset($_SESSION['id'])) {
        echo json_encode(["id"=>$_SESSION['id'], "prenom"=>$_SESSION['prenom'], "nom"=>$_SESSION['nom']]);
    } else {
        echo "NULL";
    }
?>