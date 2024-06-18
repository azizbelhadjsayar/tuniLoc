<?php
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['prenom']);
    unset($_SESSION['nom']);
    unset($_SESSION["email"]);
    unset($_SESSION["type"]);
    header("Location: login.php");
?>