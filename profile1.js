// let session_id=null;
// let session_prenom=null;
// let session_nom=null;

$(document).ready(function(){
    switchOption(document.getElementById('displayitems'));
});


function switchOption(elt) {
    document.querySelectorAll(".option").forEach((e)=>{
        e.style.backgroundColor="transparent";
        e.style.color="black";
        e.style.transition="all 0.4s ease";
    });

    elt.style.backgroundColor="rgb(168, 82, 217, 0.7)";

    if(elt.id=="displayitems") {
        document.getElementById("reviews").style.display="none";
        document.getElementById("items").style.display="flex";
        elt.style.color="white";
    }
    else if (elt.id=="displayreviews") {
        document.getElementById("items").style.display="none";
        document.getElementById("reviews").style.display="flex";
        elt.style.color="white";
    }
}


function addItem(imagePath, titre, prix, id) {
    var divItem = document.createElement("div");
    divItem.classList.add("item");
    divItem.setAttribute("data-value",id);
    divItem.addEventListener("click", function() {
        console.log("Clic sur l'élément avec l'ID :", id);
    });

    var divPhoto = document.createElement("div");
    divPhoto.classList.add("photo");
    divPhoto.style.backgroundImage= "url('"+ imagePath +"')";

    // Créer l'élément p pour le titre
    var pTitre = document.createElement("p");
    pTitre.classList.add("titre");
    pTitre.textContent = titre; // Remplacez "xxx" par le texte désiré

    // Créer l'élément p pour le prix
    var pPrix = document.createElement("p");
    pPrix.classList.add("prix");
    pPrix.textContent = prix+'TND/JOUR'; // Remplacez "xxxx" par le texte désiré

    // Créer l'élément i pour les ellipses
    var iEllipsis = document.createElement("i");
    iEllipsis.classList.add("fa-solid", "fa-ellipsis");

    // Ajouter les éléments à l'élément principal div.item
    divItem.appendChild(divPhoto);
    divItem.appendChild(pTitre);
    divItem.appendChild(pPrix);
    divItem.appendChild(iEllipsis);

    // Ajouter l'élément principal à la page (par exemple, au body)
    document.getElementById("items").appendChild(divItem);
}

function getSessionData() {
    $.ajax({
        url: './phpScripts/getSessionInfos.php',
        type: 'GET',
        success: function(response) {
            if (response !== 'NULL') {
                let result = JSON.parse(response);
                session_id=result.id;
                session_prenom=result.prenom;
                session_nom=result.nom;
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}



function displayHideItemMenu(menu) {
    if(menu.classList.contains('hiddenItemMenu')) {
        menu.classList.remove('hiddenItemMenu');
        menu.classList.add('displayedItemMenu');
    }
    else {
        menu.classList.remove('displayedItemMenu');
        menu.classList.add('hiddenItemMenu');
    }
}


function supprimerArticle (item) {
    let id = item.getAttribute('data-value');
    $.ajax({
        url: './phpScripts/supprimerArticle.php',
        type: 'GET',
        data: 'id='+id,
        success: function(response) {
            if (response !== 'NULL') {
                window.location.reload();
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}

function pauseArticle (item) {
    let id = item.getAttribute('data-value');
    if(item.getAttribute('data-dispo')=='1') {
        $.ajax({
            url: './phpScripts/pauseArticle.php',
            type: 'GET',
            data: 'id='+id,
            success: function(response) {
                if (response !== 'NULL') {
                    item.children[1].classList.remove('hiddenItemPaused');
                    item.children[1].classList.add('displayedItemPaused');
                    displayToast("success", "Votre article est mis à jour", 1000);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
    }
    else {
        $.ajax({
            url: './phpScripts/reprendreArticle.php',
            type: 'GET',
            data: 'id='+id,
            success: function(response) {
                if (response !== 'NULL') {
                    item.children[1].classList.remove('displayedItemPaused');
                    item.children[1].classList.add('hiddenItemPaused');
                    displayToast("success", "Votre article est mis à jour", 1000);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
    }
}


async function changerPDP() {
    const { value: file } = await Swal.fire({
      title: "Selectionner une photo",
      input: "file",
      inputAttributes: {
        "accept": '.jpg,.jpeg,.png,.svg',
        "aria-label": "Upload your profile picture"
      }
    });

    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        Swal.fire({
          title: "Votre photo teléchargé",
          imageUrl: e.target.result,
          imageAlt: "The uploaded picture",
          showCancelButton: true,
          confirmButtonText: "Appliquer",
          cancelButtonText: "Annuler"
        }).then((result) => {
          if (result.isConfirmed) {
            uploadImage(file);
          }
        });
      };
      reader.readAsDataURL(file);
    }
  }



  async function changerDescription() {
    const { value: text } = await Swal.fire({
        input: "textarea",
        inputLabel: "Description",
        inputPlaceholder: "Saisir votre description ici...",
        inputAttributes: {
          "aria-label": "Saisir votre description ici"
        },
        showCancelButton: true
      });
      if (text) {
        $.ajax({
            url: './phpScripts/modifierDescription.php',
            type: 'GET',
            data: 'description='+text,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response !== 'NULL') {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Votre description est modifiée avec succès!",
                        showConfirmButton: false,
                        timer: 1000
                      });
                    setTimeout(() => {
                         window.location.reload();
                    }, 1100);
                } else {
                    alert(response);
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
        // Swal.fire(text);
      }
  } 

  function uploadImage(file) {
    const formData = new FormData();
    formData.append("image", file);
    $.ajax({
        url: './phpScripts/changerPDP.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response !== 'NULL') {
                setTimeout(() => {
                     window.location.reload();
                }, 500);
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
  }


  
  function displayToast(type, message, temps){
    const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: temps,
        timerProgressBar: true
        // didOpen: (toast) => {
        //   toast.onmouseenter = Swal.stopTimer;
        //   toast.onmouseleave = Swal.resumeTimer;
        // }
      });
    Toast.fire({
        icon: type,
        title: message
    });
  }