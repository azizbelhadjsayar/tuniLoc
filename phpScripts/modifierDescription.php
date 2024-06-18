<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "config.php";
    $insert = $conn->prepare("update utilisateurs set description = ? where id = ?") ;
    $insert->execute([$_GET['description'], $_SESSION['id']]);
    echo 1;
?>