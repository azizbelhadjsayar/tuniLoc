<?php
    session_start();
    if(!isset($_SESSION["id"])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE CONNECTER</title>
    <link rel="stylesheet" href="styles7.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8bcc3f53b4.js" crossorigin="anonymous"></script>
<body>
    <?php
        include "header.php";
    ?>

    <main>
        <form id="connexionForm">
            <h1 style="text-align: center;">Connexion</h1>

            <div id="status"></div>

            <div class="form-floating">
                <input name="email" type="email" class="form-control" id="email" placeholder="EMAIL" required>
                <label for="email">EMAIL</label>
            </div><br>


            <div class="form-floating">
                <input name="motdepasse" type="password" class="form-control" id="motdepasse" placeholder="MOT DE PASSE" required>
                <label for="motdepasse">MOT DE PASSE</label>
            </div><br>

            <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Se connecter</button>
            <h6 class="mt-3">Vous n'avez pas de compte ? <a href="register.php">Créez votre compte</a></h6>
        </form>
    </main>

    <footer>
        
    </footer>
    <script src="login3.js"></script>
</body>
</html>
<?php
    }else {
        header("Location: profile.php");
    } 
?>