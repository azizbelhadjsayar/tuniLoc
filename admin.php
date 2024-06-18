<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "./phpScripts/config.php";
    if(isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGE ADMIN</title>
    
    <script src="https://kit.fontawesome.com/8bcc3f53b4.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <link rel="stylesheet" href="admin2.css">
</head>
<body>
    <div id="pageContainer">
        <div id="panel">
            <div id="logo"></div>
            <div id="options">
                <div id="accounts" onclick="chargerComptes()"><i class="fa-solid fa-user"></i>Comptes</div>
                <div id="items" onclick="chargerItems()"><i class="fa-solid fa-bicycle"></i>Articles</div>
                <!-- <div id="locations" onclick="chargerLocations()"><i class="fa-solid fa-comments-dollar"></i>Locations</div> -->
            </div>
        </div>
        <div id="content">
            <div id="header"><strong style="padding-left:80px; color: #639aff; font-size: 28px;">ESPACE ADMIN</strong>
                <form action="logout.php" method="get">
                    <button class="Btn" name="logout">
                        <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>   
                        <div class="text">Se déconnecter</div>
                    </button>
                </form>
            </div>
            
            <div id="displayContent">
                
            </div>
        </div>
    </div>

    <script src="admin6.js"></script>
</body>
</html>
<?php 
    }else{
        header("Location: login.php");
    }
?>