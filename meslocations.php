<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    include "./phpScripts/config.php";
    if(isset($_SESSION['id'])) {
    try {
        $stmt = $conn->prepare("SELECT l.*, u.prenom, u.nom, u.email, a.lat, a.lng, a.titre from locations l join utilisateurs u on l.proprietaire_id = u.id join articles a on a.id = l.article_id where l.locataire_id = ? and a.disponibilite = true order by l.date_demande desc");
        $stmt->execute([(int)$_SESSION['id']]);
        $result2 = $stmt->fetchAll();
        $num_rows2 = count($result2);
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
    <link rel="stylesheet" href="meslocations6.css">

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

    <link rel="stylesheet" href="header2.css">

</head>
<body>
<script>
    function initialiserMap(id, lat, lng) {
        var map = L.map(id, {
            center: [lat, lng],
            zoom: 10,
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: true,
            doubleClickZoom: false,
            boxZoom: false,
            touchZoom: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker = L.marker([lat, lng]).addTo(map);
    }
    </script>
    <?php include "header.php"; ?>
    <main>
        <?php if($num_rows2==0) { ?>
        <img src="images/rentals-empty.svg" alt="">
        <h3>Pas encore de location</h3>
        <p>C'est ici que vous verrez les objets que vous avez loués et leurs états</p>
        <?php } else { }?>

        <div id="locations">

            <?php 
            foreach ($result2 as $row) {
                echo "
                    <div data-id={$row['id']} class='location'>
                        <a class='map' id='map{$row['id']}' href=\"https://www.google.com/maps/search/?api=1&query={$row['lat']},{$row['lng']}\" target='_blank'></a>
                        <div class='infos'>
                            <div class='titre'><strong style='color: red;'>Article : </strong>{$row['titre']}</div>
                            <div class='proprietaire'><strong style='color: red;'>Propriétaire : </strong>{$row['prenom']}</div>
                            <div class='montant'><strong style='color: red;'>Montant : </strong>{$row['montant_total']} TND</div>
                            <div class='date_demande'><strong style='color: red;'>Demandé le : </strong>{$row['date_demande']}</div>
                            <div class='date_demande'><strong style='color: red;'>Durée : </strong>{$row['jours']} jours</div> <br>
                            <a href='mailto:{$row['email']}'>Envoyer un e-mail</a>
                            <a href='article.php?id_article={$row['article_id']}'>Voir l'article</a>
                        </div>
                        <div class='buttons'>
                            <div class='etat {$row['statut']}'>";if($row['statut']=='enattente') echo "En attente</div>";
                                                                 elseif($row['statut']=='acceptee') echo "Acceptée</div>";
                                                                 elseif($row['statut']=='refusee') echo "Refusée</div>";
                                                                 elseif($row['statut']=='annulee') echo "Annulée</div>";
                                                                 if($row['statut']=='terminee') echo "Terminée</div>";
                            if($row['statut']=='enattente') echo "<button onclick='annulerDemande(this)' class='annulerDemande'>Annuler</button>";
                            if(($row['statut']=='refusee')||($row['statut']=='annulee')||($row['statut']=='terminee')) echo "<i onclick='supprimerLocation(this)' class='fa-solid fa-trash-can'></i>";
                        echo "</div>
                    </div>    <script>initialiserMap('map{$row['id']}', {$row['lat']},{$row['lng']});</script>
                ";
            }
            ?>

        </div>
    </main>

    <script src="meslocations.js"></script>



    <script>initialiserMap('map1', 32.254,3.654);
            initialiserMap('map2', 52.254,3.654);</script>




</body>
</html>
<?php 
    }else{
        header("Location: login.php");
    }
?>