<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "../config.php";
    function deleteFolderAndContents($folderPath) {
        if (!is_dir($folderPath)) {
            throw new InvalidArgumentException("$folderPath doit être un répertoire.");
        }
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
                if (is_dir($filePath)) {
                    deleteFolderAndContents($filePath);
                } else {
                    unlink($filePath);
                }
            }
        }
        rmdir($folderPath);
    }
    
    try {
        $insert = $conn->prepare("delete from utilisateurs where id = ?") ;
        $insert->execute([$_GET['id']]);
        deleteFolderAndContents("../../utilisateurs/utilisateur".$_GET['id']);
        echo "Le compte est supprimé avec succès !";
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>


