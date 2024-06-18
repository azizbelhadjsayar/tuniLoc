function displayPhoto (photo, item) {
    if(photo!='') {
        console.log(photo);
        item.style.backgroundImage = 'url('+photo+')';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var paragraph = document.getElementById("description");
    var originalText = paragraph.innerHTML;
    if (originalText.length > 200) {
        var shortText = originalText.substring(0, 200);
        paragraph.innerHTML = shortText + '<span id="more">... <a href="#" id="more-link">Voir plus</a></span>';
        var moreLink = document.getElementById("more-link");
        var isExpanded = false;
        moreLink.addEventListener("click", function(event) {
            event.preventDefault();
            if (!isExpanded) {
                paragraph.innerHTML = originalText;
            } else {
                paragraph.innerHTML = shortText + '<span id="more">... <a href="#" id="more-link">Voir plus</a></span>';
            }
            isExpanded = !isExpanded;
        });
    }
});


function displayConfirmation() {
    document.getElementById('requestButton').style.display="none";
    document.getElementById("infosContainer").style.visibility="hidden";
    document.getElementById("submitRequest").style.display="block";
}


function sendMessage(article_id, prop_id, loc_id, prenom) {
    let elt = document.getElementById('messageField');
    if(elt.value == ''){
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Message non valide",
            text: "Vous devez saisir un message pour le propriétaire",
            showConfirmButton: true,
            timer: 2000
        });
    }
    else {
        $.ajax({
            url: './phpScripts/envoyerDemande.php',
            type: 'GET',
            data: {
                article_id: article_id,
                proprietaire_id: prop_id,
                locataire_id: loc_id,
                demande_message: document.getElementById('messageField').value,
                jours: document.getElementById('calculation').getAttribute('data-days'),
                montant: parseFloat(document.getElementById('calculation').getAttribute('data-total')),
                date_debut: document.getElementById('calculation').getAttribute('data-dateD'),
                date_fin: document.getElementById('calculation').getAttribute('data-dateF')
            },
            success: function(response) {
                if (response !== "1") {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: response,
                        text: "Une erreur lors de l'envoi de la demande",
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Demande envoyée",
                        text: ("Votre demande est envoyée avec succès à " + prenom),
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
    }
}

