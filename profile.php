<?php
    session_start();
    include "./phpScripts/config.php";
    if(isset($_SESSION['id'])&&($_SESSION['type']=='user')) {
        $prenom = $_SESSION['prenom'];
        $prenom = $_SESSION['nom'];
        $results = $conn->query("SELECT * FROM articles where proprietaire_id = ".$_SESSION['id']." and statut='accepte'");
        $result44 = $conn->query("SELECT photo_profil, description FROM utilisateurs where id = ".$_SESSION['id']);
        if($result44) $uti = $result44->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    
    <script src="https://kit.fontawesome.com/8bcc3f53b4.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <?php
        include "header.php";
    ?>
    <main>
        <div id="banner"></div>

        <div id="info">
            <div id="menu">
                <div id="photo" style="background-image:url(<?php echo $uti['photo_profil']?>)"></div> <br>
                <button onclick="changerPDP()" type="button" class="btn btn-secondary">Modifier la photo</button><br>
                <!-- <button type="button" class="btn btn-secondary">Voir mes statistiques</button><br> -->
                <button onclick="changerDescription()" type="button" class="btn btn-secondary">Modifier la description</button><br>
                <p style="text-align:center;">Répond généralement en quelques heures</p>
            </div>

            <div id="content">
                <div id="username"><?php echo $_SESSION['prenom'].' '.$_SESSION['nom'] ?></div>
                <div id="description"><?php if($uti['description']) echo $uti['description']?></div>
            </div>
        </div>

        <div id="switcher">
            <div id="switchercontainer">
                <div id="displayitems" class="option" onclick="switchOption(this)">MAGASIN DE LOCATION</div>
                <div id="displayreviews" class="option" onclick="switchOption(this)">AVIS</div>
            </div>
        </div>
        <div id="switcherdisplay">
            <div class="displayoption" id="items">
                <div class="item" style="background-color: transparent; cursor: default; display: flex; flex-direction: column; align-items: center;">
                    <img src="images/newItem.svg" width="150px">
                    <p class="titre" style="text-align: center;">Quelque chose d'autre que vous pourriez louer ?</p>
                    <a href="ajouterArticle.php">Ajouter une annonce</a>
                </div>

                <?php
                    for($i=0; $i<$results->rowCount(); $i++) {
                        $row = $results->fetch();
                        if ($row['disponibilite']) {
                            $pauseClass = 'hiddenItemPaused';
                            $menuPauseOption = 'Mettre en pause';
                        } else {
                            $pauseClass = 'displayedItemPaused';
                            $menuPauseOption = 'Reprendre';
                        }
                        echo '<div class="item" data-value="' . $row['id'] . '" data-dispo="'.$row['disponibilite'].'">
                                <div class="menu hiddenItemMenu">
                                    
                                    <a onclick="pauseArticle(this.parentNode.parentNode)">'.$menuPauseOption.'</a>
                                    <a onclick="supprimerArticle(this.parentNode.parentNode)">Supprimer</a>
                                </div>
                                <div class="paused '.$pauseClass.'">
                                    En pause
                                </div>
                                <div class="photo" style="background-image: url(\'' . $row['photo1'] . '\');"></div>
                                <p class="titre">' . $row['titre'] . '</p>
                                <p class="prix">' . $row['prix_jour'] . 'TND/jour</p>
                                <i class="fa-solid fa-ellipsis" aria-hidden="true" onclick="displayHideItemMenu(this.parentNode.children[0])"></i>
                            </div>';
                    }
                ?>
                
            </div>
            <div class="displayoption" id="reviews">Pas d'avis</div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="profile1.js"></script>

</body>
</html>
<?php 
    } elseif ($_SESSION['type']=="admin") {
        header("Location: admin.php");
    }
    else{
        header("Location: login.php");
    }
?>