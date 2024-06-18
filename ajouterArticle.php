<?php
    session_start();
    if(isset($_SESSION['id'])) {
        $prenom = $_SESSION['prenom'];
        $prenom = $_SESSION['nom'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article</title>

    <link rel="stylesheet" href="ajouterArticle7.css">
    
    <link rel="stylesheet" href="popup.css">
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
    <!-- calendar librariy -->

    <!-- calendar librariy -->
</head>
<body>
    <?php include "header.php" ?>
    <div class="popup" id="popup">
        <div class="categoriePopup" id="categoriePopup">
            <div class="title"><span id="titleText">Categories</span>
                <i id="closeCat" class="fa-solid fa-circle-xmark" onclick="hideCategoriePopup()"></i>
                <i id="returnCat" class="fa-solid fa-circle-chevron-left" onclick="returnToCategories()"></i>
            </div>
            <ul id="subCategorie">
                    
            </ul>
            <div class="categories" id="categories">
                <div id="electronique" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/electronique.png" alt="">
                    <p>Électronique</p>
                    <ul style="display: none;">
                        <li>Audio et vidéo</li>
                        <li>Informatique et portables</li>
                        <li>Jeux vidéo (consoles, jeux, manettes...)</li>
                        <li>Autres</li>
                    </ul>
                </div>
                
                <div id="maison" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/maison.png" alt="">
                    <p>Maison et jardin</p>
                    <ul style="display: none;">
                        <li>Mobilier</li>
                        <li>Outils et bricolage</li>
                        <li>Extérieur et terrasse</li>
                        <li>Autres</li>
                    </ul>
                </div>
                <div id="vehicules" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/vehicules.png" alt="">
                    <p>Véhicules</p>
                    <ul style="display: none;">
                        <li>Voitures</li>
                        <li>Motos et scooters</li>
                        <li>Vélos et trottinettes électriques</li>
                        <li>Camions et remorques</li>
                        <li>Autres</li>
                    </ul>
                </div>
                <div id="construction" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/construction.png" alt="">
                    <p>Équipements et outils de construction</p>
                    <ul style="display: none;">
                        <li>Outils électriques (perceuses, scies, marteaux...)</li>
                        <li>Echafaudages et échelles</li>
                        <li>Autres</li>
                    </ul>
                </div>
                <div id="evenements" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/evenements.png" alt="">
                    <p>Articles de fête et d'événement</p>
                    <ul style="display: none;">
                        <li>Tables et chaise</li>
                        <li>Décorations</li>
                        <li>Matériel de restauration</li>
                        <li>Eclairage d'événement</li>
                        <li>Sonorisation</li>
                        <li>Autres</li>
                    </ul>
                </div>

                <div id="photographie" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/photographie.png" alt="">
                    <p>Film et photographie</p>
                    <ul style="display: none;">
                        <li>Appareils photo et objectifs</li>
                        <li>Matériel d'éclairage</li>
                        <li>Matériel audio</li>
                        <li>Matériel de prise de vue</li>
                        <li>Autres</li>
                    </ul>
                </div>


                <div id="sport" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/sport.png" alt="">
                    <p>Sports et loisirs</p>
                    <ul style="display: none;">
                        <li>Matériel de fitness</li>
                        <li>Matériel de camping</li>
                        <li>Equipement de sports d'équipe</li>
                        <li>Autres</li>
                    </ul>
                </div>
                <div id="autre" class="categorie" onclick="openSubcategories(this.children[1].innerHTML,this.id, this.lastElementChild)">
                    <img src="./categorieIcons/autre.png" alt="">
                    <p>Autres</p>
                    <ul style="display: none;">
                        <li>Vetements et accessoires (robes, costumes, bijoux...)</li>
                        <li>Matériel de musique (guitares, pianos, batteries...)</li>
                        <li>Livres et films (livres, DVD...)</li>
                        <li>Outils et fournitures pour animaux de compagnie (laisses, colliers, cages...)</li>
                        <li>Autres</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <main>
        <h2>Nouvelle annonce</h2>
        <form id="myForm">
            <h2>Ajouter des photos</h2>
            <div class="photos" id="photos">
                <label id="labelImage1" for="imgInp1" class="imageContainer" >
                    <div class="imageIcon" id="imgInp1preview"></div>
                </label>
                <input class="imageInput" name="imgInp1" accept=".jpg,.png,.jpeg" type='file' id="imgInp1" onchange="loadImage(this.id)" required/>
        
                <label for="imgInp2" class="imageContainer">
                    <div class="imageIcon" id="imgInp2preview"></div>
                </label>
                <input class="imageInput" name="imgInp2" accept=".jpg,.png,.jpeg" type='file' id="imgInp2" onchange="loadImage(this.id)"/>

                <label for="imgInp3" class="imageContainer">
                    <div class="imageIcon" id="imgInp3preview"></div>
                </label>
                <input class="imageInput" name="imgInp3" accept=".jpg,.png,.jpeg" type='file' id="imgInp3" onchange="loadImage(this.id)"/>
        
                <label for="imgInp4" class="imageContainer">
                    <div class="imageIcon" id="imgInp4preview"></div>
                </label>
                <input class="imageInput" name="imgInp4" accept=".jpg,.png,.jpeg" type='file' id="imgInp4" onchange="loadImage(this.id)"/>

                <label for="imgInp5" class="imageContainer">
                    <div class="imageIcon" id="imgInp5preview"></div>
                </label>
                <input class="imageInput" name="imgInp5" accept=".jpg,.png,.jpeg" type='file' id="imgInp5" onchange="loadImage(this.id)"/>

            </div>

            <h2 style="margin-top: 20px;">Titre</h2>
            <div class="inputContainer">
                <input name="titre" required type="text" placeholder="Title 60 char max" maxlength="60">
            </div>

            <h2 style="margin-top: 20px;">Catégorie</h2>
            <div class="inputContainer">
                <input name="categorie" onclick="openCategories()" placeholder="Cliquer ici pour sélectionner la catégorie" type="text" id="categorieInput" maxlength="0" readonly required>
            </div>

            <h2 style="margin-top: 20px;">Description</h2>
            <div class="inputContainer">
                <textarea name="description" placeholder="Décrire votre article en 400 caractères au maximum" name="" id="" maxlength="" rows="10" required></textarea>
            </div>

            <h2 style="margin-top: 20px; margin-bottom: 10px;">Prix ​​de location (TND) par :</h2>
            <div class="inputContainer pricesContainer">
                <label class="priceLabel">JOUR
                    <input name="prix_jour" class="prices form-control" id="dayPrice" type="text" oninput="onlyNumbers(this.id)" required>
                </label>
                <label class="priceLabel">SEMAINE
                    <input name="prix_semaine" class="prices" id="weekPrice" type="text" oninput="onlyNumbers(this.id)">
                </label>

                <label class="priceLabel">MOIS
                    <input name="prix_mois" class="prices" id="monthPrice" type="text" oninput="onlyNumbers(this.id)">
                </label>
            </div>

            <h2 style="margin-top: 20px;">Valeur ​​de l'article (TND)</h2>
            <div class="inputContainer pricesContainer">
                <label class="priceLabel">
                    <input name="valeur" class="prices" id="dayPrice" type="text" oninput="onlyNumbers(this.id)" required>
                </label>
            </div>

            <h2 style="margin-top: 20px; margin-bottom: 10px;">Localisation ​​de l'article</h2>
            <div id="map"></div>
            <input name="lat" required type="text" id="lat">
            <input name="lng" required type="text" id="lng">

            <div id="buttonContainer">
                <button id="submitButton" type="submit">Ajouter</button>
            </div>
        </form>
    </main>

    <script src="ajouterArticle.js"></script>
    <script src="popup.js"></script>
    <script src="mapConfiguration.js"></script>
    <!-- calendar librariy -->

    <!-- calendar librariy -->
</body>
</html>

<?php 
    }else{
        header("Location: login.php");
    }
?>