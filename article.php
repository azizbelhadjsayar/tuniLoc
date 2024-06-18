<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "./phpScripts/config.php";
    if(isset($_SESSION['id'])) {
        $stmt = $conn->prepare("SELECT * from locations where locataire_id = ? and  article_id = ? and statut='enattente'");
        $stmt->execute([(int)$_SESSION['id'],(int)$_GET['id_article']]);
        $result2 = $stmt->fetchAll();
        $num_rows2 = count($result2);

        $stmt = $conn->prepare("SELECT * from articles where proprietaire_id = ? and  id = ?");
        $stmt->execute([(int)$_SESSION['id'],(int)$_GET['id_article']]);
        $result3 = $stmt->fetchAll();
        $num_rows3 = count($result3);
    }
    try {
        $stmt = $conn->prepare("SELECT a.*, u.prenom, u.photo_profil, u.description as udesc from articles a join utilisateurs u on a.proprietaire_id =u.id where a.id = ? and disponibilite = true");
        $stmt->execute([(int)$_GET['id_article']]);
        $result = $stmt->fetch();

    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page article</title>
    <link rel="stylesheet" href="article8.css">

    <script src="https://kit.fontawesome.com/8bcc3f53b4.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script> 

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <link rel="stylesheet" href="confirmationPopup.css">

    <link rel="stylesheet" href="air-datepicker/air-datepicker.css">
    <link rel="stylesheet" href="header2.css">

</head>
<body>
    <?php include "header.php"; ?>
    <main>
        <div class="infos" id="infosContainer">
            <div id="photos">
                <div id="displayedPhoto" style="background-image: url('<?php echo $result['photo1'] ?>')"></div>
                <div id="allPhotos">
                    <div class="photo" id="photo1" style="background-image: url('<?php echo $result['photo1'] ?>')" onclick="displayPhoto('<?php echo $result['photo1'] ?>', this.parentNode.parentNode.children[0])"></div>
                    <div class="photo" id="photo2" style="background-image: url('<?php echo $result['photo2'] ?>')" onclick="displayPhoto('<?php echo $result['photo2'] ?>', this.parentNode.parentNode.children[0])"></div>
                    <div class="photo" id="photo3" style="background-image: url('<?php echo $result['photo3'] ?>')" onclick="displayPhoto('<?php echo $result['photo3'] ?>', this.parentNode.parentNode.children[0])"></div>
                    <div class="photo" id="photo4" style="background-image: url('<?php echo $result['photo4'] ?>')" onclick="displayPhoto('<?php echo $result['photo4'] ?>', this.parentNode.parentNode.children[0])"></div>
                    <div class="photo" id="photo5" style="background-image: url('<?php echo $result['photo5'] ?>')" onclick="displayPhoto('<?php echo $result['photo5'] ?>', this.parentNode.parentNode.children[0])"></div>
                </div>
            </div>

            <strong style="font-size:20px; color:#814bcc;">Categorie :</strong>
            <div id="categorie"> <?php echo $result['categorie'] ?> > <?php echo $result['sous_categorie'] ?> </div>
            <br><strong style="font-size:20px; color:#814bcc;">Description :</strong>
            <div id="description"><?php echo $result['description'] ?></div>
            <br><strong style="font-size:20px; color:#814bcc;">Localisation :</strong>
            <div id="localisation"></div>
            <hr><strong style="font-size:20px; color:#814bcc;">Article appartenant à <span id="nom"><?php echo $result['prenom'] ?></span></strong>
            <hr>
            <div id="profileInfos">
                <!-- <div id="buttons">
                    <button>Message à <span><?php echo $result['prenom'] ?></span></button>
                    <button>Voir le profil de <span><?php echo $result['prenom'] ?></span></button>
                </div> -->
            </div>
        </div>
        
        <div class="louer">
            <div id="titre"><?php echo $result['titre'] ?></div>
            
            <div id="container">
                <div id="proprietairePosition"><?php echo ($result['adresse'] !== 'null') ? $result['prenom'].' à '.$result['adresse'] : ""; ?></div>
                <div id="prices">
                    <div class="prixContainer" id="jour">
                        <div>Tous les jours</div>
                        <div id="prix_jour" style="color: rgba(26, 49, 144); font-weight: 600;"><?php echo 'TND '.$result['prix_jour']?></div><span style="color: gray;">/jour</span>
                    </div>
                    <?php if($result['prix_semaine']!=0) { ?>
                    <div class="prixContainer" id="semaine">
                        <div>7 jours +</div>
                        <div id="prix_semaine" style="color: rgba(26, 49, 144); font-weight: 600;"><?php echo 'TND '.$result['prix_semaine']?></div><span style="color: gray;">/jour</span>
                    </div>
                    <?php } ?>
                    <?php if($result['prix_mois']!=0) { ?>
                    <div class="prixContainer" id="mois">
                        <div>31 jours +</div>
                        <div id="prix_mois" style="color: rgba(26, 49, 144); font-weight: 600;"><?php echo 'TND '.$result['prix_mois']?></div><span style="color: gray;">/jour</span>
                    </div>
                    <?php } ?>
                </div>
                <button <?php if(isset($_SESSION['id'])) {if(($num_rows2>0)||($num_rows3>0)) echo "disabled";}?> id="locButton" onclick="displayhidePopup()"><?php if(isset($_SESSION['id'])) {if($num_rows3>0) echo "Votre article"; elseif ($num_rows2>0) echo "Demande en attente"; else echo "Vérifier le prix et la disponibilité"; } else echo "Vérifier le prix et la disponibilité"; ?></button>   
            </div>

            <div id="calculation">
                <div id="periode"></div>
                <div id="calcul">
                    <div id="calcul1">
                        <div class="left"></div>
                        <div class="right"></div>
                    </div>
                    <div id="calcul2">
                        <div class="left"></div>
                        <div class="right"></div>
                    </div>
                </div>
                <div id="total">
                    <div id="left">Total</div>
                    <div id="right"></div>
                </div>
                <button id="requestButton" onclick="<?php if(isset($_SESSION['id'])) echo 'displayConfirmation()'; else echo "window.location.href='login.php?id_article={$_GET['id_article']}'";?>">Demander</button>
            </div>
        </div>
        <div class="infos" id="submitRequest">
            <h2>Voir les disponibilités</h2>
            <p>Demandez une confirmation de disponibilité au propriétaire avant de payer et vérifiez.</p>
            <h6>Envoyer un message au propriétaire (obligatoire)</h6>
            <textarea required name="" id="messageField" cols="30" rows="10"></textarea>
            <p>Nous vous recommandons de vérifier la disponibilité de plusieurs options/propriétaires pour maximiser les chances de trouver un article qui convient à vos dates et à votre ramassage.</p>
            <div id="buttons">
                <button id="cancelButton" onclick="window.location.reload();" >Annuler</button>
                <button id="submitButton" onclick="sendMessage(<?php echo $result['id'] ?>,<?php echo $result['proprietaire_id'] ?>,<?php echo $_SESSION['id'] ?>, '<?php echo $result['prenom'] ?>')">Envoyer la demande</button>
            </div>
        </div>
    </main>

    <script src="article.js"></script>

    <?php 
        $latitude = floatval($result['lat']);
        $longitude = floatval($result['lng']);
    ?>

    <script>
        var map = L.map('localisation', {
            center: [<?php echo $latitude; ?>, <?php echo $longitude; ?>],
            zoom: 15,
            zoomControl: false,
            dragging: true,
            scrollWheelZoom: true,
            doubleClickZoom: false,
            boxZoom: false,
            touchZoom: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);
        var popupContent = "<a href='https://www.google.com/maps/search/?api=1&query=<?php echo $latitude; ?>, <?php echo $longitude; ?>' target='_blank'>Voir sur Google Maps</a>";
        marker.bindPopup(popupContent);
        marker.openPopup();
    </script>
    <?php include "confirmationPopup.php" ?>
</body>
</html>