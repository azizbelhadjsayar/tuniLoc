<?php
    session_start();
    include "config.php";
    $nbItems = 0;
    try {
        $stmt = $conn->prepare("SELECT max(id) as nbitems FROM articles");
        $stmt->execute();
        $result = $stmt->fetch();
        if($result['nbitems']!==null)
            $nbItems = $result['nbitems'];
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>