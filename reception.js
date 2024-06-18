function chargerDemande(d) {
    while (document.getElementById('statutLocation').classList.length > 0) {
        document.getElementById('statutLocation').classList.remove(document.getElementById('statutLocation').classList.item(0));
    }


    if(d.statut=='acceptee') {
        document.getElementById("articleEnPause").style.display= "none";
        document.getElementById('statutLocation').innerHTML='Acceptée';
        document.getElementById('confirmer').style.display = 'none';
        document.getElementById('refuser') .style.display = 'none';
    }
    else if(d.statut=='enattente') {
        document.getElementById("articleEnPause").style.display= "none";
        document.getElementById('statutLocation').innerHTML='En attente de validation';
        document.getElementById('confirmer').style.display = 'block';
        document.getElementById('refuser') .style.display = 'block';
        document.getElementById("confirmer").disabled = false;
        document.getElementById("refuser").disabled = false;
    }
    else if (d.statut=='refusee') {
        document.getElementById("articleEnPause").style.display= "none";
        document.getElementById('statutLocation').innerHTML='Refusée';
        document.getElementById('confirmer').style.display = 'none';
        document.getElementById('refuser') .style.display = 'none';
    }

    if((d.statut=='enattente')&&(d.disponibilite=="0")) {
        document.getElementById("confirmer").disabled = true;
        document.getElementById("refuser").disabled = true;
        document.getElementById("articleEnPause").style.display= "block";
    }
    document.getElementById('statutLocation').classList.add(d.statut);
    document.getElementById('demandes').style.width='25%';
    document.getElementById('discussion').style.display='block';
    document.getElementById('discussion').setAttribute('data-id',d.id);
    document.getElementById('discussion').children[0].children[0].style.backgroundImage='url('+d.photo_profil+')';
    document.getElementById('discussion').children[0].children[1].innerHTML = d.prenom;
    document.getElementById('imageArticle').style.backgroundImage='url('+d.photo1+')';
    document.getElementById('titreArticle').innerHTML=d.titre;
    document.getElementById('gains').innerHTML ="Vos gains : "+ (parseFloat(d.montant_total)-15)+" TND";
    if(parseInt(d.jours)==1)
        document.getElementById('duree').innerHTML ="1 jour ("+formatDateToFrench(d.date_debut)+")";
    else
        document.getElementById('duree').innerHTML =d.jours+" jours ("+formatDateToFrench(d.date_debut)+" - "+formatDateToFrench(d.date_fin)+")";
    document.getElementById('message').innerHTML =d.demande_message;
}


function formatDateToFrench(dateString) {
    const date = new Date(dateString);
    const mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    const jour = date.getDate();
    const moisEnLettres = mois[date.getMonth()];
    const dateFormatee = jour + " " + moisEnLettres;
    return dateFormatee;
}

function confirmerLocation(elt) {
    let id_location = elt.getAttribute('data-id');
    $.ajax({
        url: './phpScripts/AccepterRefuserLocation.php',
        type: 'GET',
        data: 'id_location='+id_location+'&type=acceptee',
        success: function(response) {
            if (response !== 'NULL') {
                console.log(response);
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

function refuserLocation(elt) {
    let id_location = elt.getAttribute('data-id');
    $.ajax({
        url: './phpScripts/AccepterRefuserLocation.php',
        type: 'GET',
        data: 'id_location='+id_location+'&type=refusee',
        success: function(response) {
            if (response !== 'NULL') {
                console.log(response);
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