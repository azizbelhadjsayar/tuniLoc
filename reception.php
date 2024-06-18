<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "./phpScripts/config.php";
    function getTime($datetimeString) {
        $dateTime = new DateTime($datetimeString);
        $hours = $dateTime->format('H');
        $minutes = $dateTime->format('i');
        return ($hours.':'.$minutes);
    }
    if(isset($_SESSION['id'])) {
    try {
        $stmt = $conn->prepare("select l.id, l.statut, u.prenom, u.email, u.photo_profil, a.photo1, a.titre, a.disponibilite, l.montant_total, l.jours, l.date_debut, l.date_fin, l.demande_message, l.date_demande from locations l join utilisateurs u on l.locataire_id = u.id join articles a on l.article_id = a.id WHERE l.proprietaire_id = ? and l.statut!='annulee' order by l.date_demande desc");
        $stmt->execute([(int)$_SESSION['id']]);
        $result2 = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes locations</title>
    <link rel="stylesheet" href="reception5.css">

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

    <script src="reception.js"></script>

</head>
<body>

    <?php include "header.php"; ?>
    <main>
    <div id="discussion" data-id="">
            <div class="banner">
                <div id="locatairePhoto"></div>
                <div id="locatairePrenom"></div><span id="statutLocation" class="enattente">aaaaaaaa</span><span id="articleEnPause">Votre article est en pause réactivez-le pour répondre !</span>
            </div>   
            <div class="content">
                <div class="article">
                    <h5>Demande de disponibilité</h5>
                    <div class="articleContainer">
                        <div id='imageArticle' class="image"></div>
                        <div id='titreArticle' class="titre"></div>
                    </div>
                    <div id='gains' class="gains"></div>
                    <div id='duree' class="duree"></div>
                    <button id='confirmer' class="button" onclick="confirmerLocation(this.parentNode.parentNode.parentNode)">Oui, c’est disponible</button>
                    <button id='refuser' class="button" onclick="refuserLocation(this.parentNode.parentNode.parentNode)">Rejeter la demande</button>
                </div>
                <div id='message' class="message"></div>
            </div>
        </div>

        <div id="demandes">

            <?php
            $i=1;
            foreach ($result2 as $row) {
                $temps = getTime($row['date_demande']);
                $rowJSON = json_encode($row);
                if($i===1) echo "<script>chargerDemande($rowJSON)</script>";
                echo "<div data-id='{$row['id']}' class='demande' onclick='chargerDemande($rowJSON)'>
                <div class='photoArticle' style='background-image: url({$row['photo1']})'></div>
                <div class='infos'>
                    <div class='nomArticle'>{$row['titre']}</div>
                    <div class='nomDemandeur'>{$row['prenom']}</div>
                    <div class='message'>{$row['demande_message']}</div>
                </div>
                <div class='temps'>$temps</div>"; 
                if($row['statut']=='enattente') echo "<div class='enAttenteAlert'></div>";
                echo "</div>"; $i++;
            }
            ?>

            
        </div>


    </main>



</body>
</html>
<?php 
    }else{
        header("Location: login.php");
    }
?>