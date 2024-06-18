chargerComptes();
function initialiserSplide (id) {
    var splide = new Splide( '#'+id, {
    type  : 'slide',
    rewind: true,
    });
    splide.mount();
}


function chargerComptes() {
    $.ajax({
        url: ('./phpScripts/adminScripts/getAccounts.php'),
        type: 'GET',
        success: function(response) {
            if (response !== 'NULL') {
                let result = JSON.parse(response);
                document.getElementById("displayContent").innerHTML='';
                result.forEach((element) => {
                    document.getElementById("displayContent").appendChild(createAccountElement(element))
                });
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}

function chargerItemsUser(elt) {
    id= elt.getAttribute('id');
    $.ajax({
        url: ('./phpScripts/adminScripts/getItemsByUser.php'),
        type: 'GET',
        data: 'prop_id='+id,
        success: function(response) {
            if (response !== 'NULL') {
                let result = JSON.parse(response);
                document.getElementById("displayContent").innerHTML='';
                result.forEach((element) => {
                    document.getElementById("displayContent").appendChild(createItemElement(element))
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Pas d'articles publiés pour ce compte",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}

function chargerItems() {
    $.ajax({
        url: ('./phpScripts/adminScripts/getItems.php'),
        type: 'GET',
        success: function(response) {
            if (response !== 'NULL') {
                let result = JSON.parse(response);
                document.getElementById("displayContent").innerHTML='';
                result.forEach((element) => {
                    document.getElementById("displayContent").appendChild(createItemElement(element))
                });
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}
function chargerLocations() {
    
}

function susactCompte(account) {
    let statut = account.getAttribute('data-statut');
    let id = account.getAttribute('id');
    let stat = "suspendu";
    if(statut=="suspendu") stat="actif";
    $.ajax({
        url: ('./phpScripts/adminScripts/ActiverSuspendreAccount.php'),
        type: 'GET',
        data: "statut="+stat+"&id="+id,
        success: function(response) {
            if (response !== 'NULL') {
                chargerComptes();
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: response,
                    showConfirmButton: false,
                    timer: 1000
                });
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}

function supprimerCompte(account) {
    swal.fire({
        title: "Vous voulez vraiement supprimer ce compte ?",
        text: "Annuler si vous n'etes pas sur.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer!',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: ('./phpScripts/adminScripts/supprimerAccount.php'),
                type: 'GET',
                data: "id="+account.id,
                success: function(response) {
                    if (response !== 'NULL') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response,
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(() => {
                            chargerComptes();
                        }, 1100);
                    } else {
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred during AJAX request:', error);
                }
            });
        } else {
          // Handle cancellation
        }
      });
} 




function createAccountElement(account) {
    // Créer le conteneur principal
    let accountDiv = document.createElement("div");
    accountDiv.className = "account";
    accountDiv.id = account.id;
    accountDiv.setAttribute("data-statut", account.statut);

    // Créer l'image du profil
    let profileImageDiv = document.createElement("div");
    profileImageDiv.className = "profileImage";
    profileImageDiv.setAttribute('style','background-image:url("'+account.photo_profil+'")');
    accountDiv.appendChild(profileImageDiv);

    // Créer le nom
    let nameDiv = document.createElement("div");
    nameDiv.className = "name";
    nameDiv.textContent = account.prenom + " " + account.nom;
    accountDiv.appendChild(nameDiv);

    // Créer le nombre d'items
    let nbItemsDiv = document.createElement("div");
    nbItemsDiv.className = "nbItems";
    nbItemsDiv.textContent = "Total articles : "+ account.nbItems;
    accountDiv.appendChild(nbItemsDiv);

    // Créer la date de création
    let dateCreationDiv = document.createElement("div");
    dateCreationDiv.className = "dateCreation";
    dateCreationDiv.textContent = "Créé le : "+account.date_creation;
    accountDiv.appendChild(dateCreationDiv);

    // Ajouter un saut de ligne
    accountDiv.appendChild(document.createElement("br"));

    // Créer le bouton "Suspendre"
    let suspendButton = document.createElement("button");
    suspendButton.className = "pushable";
    suspendButton.setAttribute("onclick", "susactCompte(this.parentNode)");

    let suspendShadow = document.createElement("span");
    suspendShadow.className = "shadow";
    suspendButton.appendChild(suspendShadow);

    let suspendEdge = document.createElement("span");
    suspendEdge.className = "edge";
    suspendButton.appendChild(suspendEdge);

    let suspendFront = document.createElement("span");
    suspendFront.className = "front";
    if(account.statut == "actif") {
        suspendFront.textContent = "Suspendre";
        suspendFront.setAttribute('style','background-color:rgb(237, 150, 0)');
        suspendEdge.setAttribute('style','background-color: rgb(229, 203, 6)');
    } else {
        suspendFront.textContent = "Activer";
        suspendFront.setAttribute('style','background-color:rgb(10, 122, 0)');
        suspendEdge.setAttribute('style','background-color: rgb(31, 200, 13)');
    }
    suspendButton.appendChild(suspendFront);

    accountDiv.appendChild(suspendButton);
    accountDiv.appendChild(document.createElement("br"));

    // Créer le bouton "Voir articles"
    let viewButton = document.createElement("button");
    viewButton.className = "cssbuttons-io-button";
    viewButton.setAttribute("onclick", "chargerItemsUser(this.parentNode)");
    viewButton.textContent = " Voir articles";

    let viewIconDiv = document.createElement("div");
    viewIconDiv.className = "icon";

    let viewSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    viewSvg.setAttribute("height", "24");
    viewSvg.setAttribute("width", "24");
    viewSvg.setAttribute("viewBox", "0 0 24 24");

    let viewPath1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    viewPath1.setAttribute("d", "M0 0h24v24H0z");
    viewPath1.setAttribute("fill", "none");

    let viewPath2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    viewPath2.setAttribute("d", "M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z");
    viewPath2.setAttribute("fill", "currentColor");

    viewSvg.appendChild(viewPath1);
    viewSvg.appendChild(viewPath2);
    viewIconDiv.appendChild(viewSvg);
    viewButton.appendChild(viewIconDiv);

    accountDiv.appendChild(viewButton);
    accountDiv.appendChild(document.createElement("br"));

    // Créer le bouton "Supprimer"
    let deleteButton = document.createElement("button");
    deleteButton.className = "button";
    deleteButton.setAttribute("onclick", "supprimerCompte(this.parentNode)");

    let deleteSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    deleteSvg.setAttribute("viewBox", "0 0 448 512");
    deleteSvg.setAttribute("class", "svgIcon");

    let deletePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    deletePath.setAttribute("d", "M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z");
    deleteSvg.appendChild(deletePath);
    deleteButton.appendChild(deleteSvg);

    accountDiv.appendChild(deleteButton);

    return accountDiv;
}


function createItemElement(item) {
    // Créer le conteneur principal
    let itemDiv = document.createElement("div");
    itemDiv.className = "article";
    itemDiv.id = item.id;
    itemDiv.setAttribute("data-userid", item.proprietaire_id);

    // Créer le carousel d'images
    let carouselSection = document.createElement("section");
    carouselSection.id = "image-carousel" + item.id;
    carouselSection.className = "splide";
    carouselSection.setAttribute("aria-label", "Beautiful Images");

    let splideTrack = document.createElement("div");
    splideTrack.className = "splide__track";

    let splideList = document.createElement("ul");
    splideList.className = "splide__list";

    if(item.photo1!==null) {
        let splideSlide = document.createElement("li");
        splideSlide.className = "splide__slide";
        let img = document.createElement("img");
        img.src = item.photo1;
        splideSlide.appendChild(img);
        splideList.appendChild(splideSlide);
    }

    if(item.photo2!==null) {
        let splideSlide = document.createElement("li");
        splideSlide.className = "splide__slide";
        let img = document.createElement("img");
        img.src = item.photo2;
        splideSlide.appendChild(img);
        splideList.appendChild(splideSlide);
    }

    if(item.photo3!==null) {
        let splideSlide = document.createElement("li");
        splideSlide.className = "splide__slide";
        let img = document.createElement("img");
        img.src = item.photo3;
        splideSlide.appendChild(img);
        splideList.appendChild(splideSlide);
    }

    if(item.photo4!==null) {
        let splideSlide = document.createElement("li");
        splideSlide.className = "splide__slide";
        let img = document.createElement("img");
        img.src = item.photo4;
        splideSlide.appendChild(img);
        splideList.appendChild(splideSlide);
    }

    if(item.photo5!==null) {
        let splideSlide = document.createElement("li");
        splideSlide.className = "splide__slide";
        let img = document.createElement("img");
        img.src = item.photo5;
        splideSlide.appendChild(img);
        splideList.appendChild(splideSlide);
    }

    splideTrack.appendChild(splideList);
    carouselSection.appendChild(splideTrack);
    itemDiv.appendChild(carouselSection);


    // Créer le titre
    let titleDiv = document.createElement("div");
    titleDiv.className = "title";
    titleDiv.textContent = item.titre;
    itemDiv.appendChild(titleDiv);

    // Créer la localisation
    let locationDiv = document.createElement("div");
    locationDiv.className = "location";

    locationDiv.textContent = item.adresse!=null ? item.adresse : "non disponible";
    itemDiv.appendChild(locationDiv);

    // Créer la catégorie
    let categoryDiv = document.createElement("div");
    categoryDiv.className = "categorie";
    categoryDiv.textContent = item.categorie+" > "+item.sous_categorie;
    itemDiv.appendChild(categoryDiv);

    // Créer la section des prix
    let pricesDiv = document.createElement("div");
    pricesDiv.className = "prices";

    let dayPriceDiv = document.createElement("div");
    dayPriceDiv.className = "day";
    dayPriceDiv.textContent = item.prix_jour + " TND par jour";
    pricesDiv.appendChild(dayPriceDiv);

    if(item.prix_semaine!=0) {
        let weekPriceDiv = document.createElement("div");
        weekPriceDiv.className = "week";
        weekPriceDiv.textContent = item.prix_semaine + " TND 7jours+";
        pricesDiv.appendChild(weekPriceDiv);
    }

    if(item.prix_mois!=0) {
        let monthPriceDiv = document.createElement("div");
        monthPriceDiv.className = "month";
        monthPriceDiv.textContent = item.prix_mois + " TND 30jours+";
        pricesDiv.appendChild(monthPriceDiv);
    }

    itemDiv.appendChild(pricesDiv);

    // Créer le conteneur des boutons
    let itemButtonsDiv = document.createElement("div");
    itemButtonsDiv.className = "itemButtons";

    // Créer le bouton "Supprimer"
    let deleteButton = document.createElement("button");
    deleteButton.className = "custom-btn btn-2";
    deleteButton.setAttribute("onclick", "deleteItem(this.parentNode.parentNode)");
    deleteButton.textContent = "Supprimer";
    itemButtonsDiv.appendChild(deleteButton);

    itemDiv.appendChild(itemButtonsDiv);

    setTimeout(() => {
        initialiserSplide(carouselSection.id);
    }, 100);

    return itemDiv;
}


function displayToast(type, message, temps){
    const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: temps,
        timerProgressBar: true
      });
    Toast.fire({
        icon: type,
        title: message
    });
  }




initialiserSplide('image-carousel123');


function deleteItem(item) {
    let id = item.getAttribute('id');
    let userid = item.getAttribute('data-userid');
    swal.fire({
        title: "Vous voulez vraiement supprimer cet article ?",
        text: "Annuler si vous n'etes pas sur.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer!',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: ('./phpScripts/adminScripts/supprimerArticle.php'),
                type: 'GET',
                data: "id="+id+"&userid="+userid,
                success: function(response) {
                    if (response !== 'NULL') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response,
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(() => {
                            chargerComptes();
                        }, 1100);
                    } else {
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred during AJAX request:', error);
                }
            });
        } else {
          // Handle cancellation
        }
      });
}