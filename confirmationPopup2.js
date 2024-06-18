const date = new Date();
const formattedDate = `${date.getMonth() + 1}/${date.getDate()+1}/${date.getFullYear()}`;


new AirDatepicker('#calendrier',{
    minDate:formattedDate,
    range:true,
    multipleDatesSeparator:" jusqu'à ",
    buttons : 'clear',
    locale:{
        days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        daysMin: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthsShort: ['Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: "Aujourd'hui",
        clear: 'Effacer',
        dateFormat: 'dd/MM/yyyy',
        timeFormat: 'HH:mm',
        firstDay: 1
    },
    isMobile: true,
    autoClose: true,
    onSelect: ( ) => {
        document.getElementById("container").style.display = "none";
        document.getElementById("calculation").style.display = "flex";

        let dateString = document.getElementById("calendrier").value;
        let longueur = document.getElementById("calendrier").value.length;
        
        let prix_jour=null;
        let prix_semaine=null;
        let prix_mois=null;

        if(document.getElementById('prix_jour')) {
            prix_jour = parseFloat(document.getElementById('prix_jour').innerHTML.split('TND')[1])
        }

        if(document.getElementById('prix_semaine')) {
            prix_semaine = parseFloat(document.getElementById('prix_semaine').innerHTML.split('TND')[1])
        }

        if(document.getElementById('prix_mois')) {
            prix_mois = parseFloat(document.getElementById('prix_mois').innerHTML.split('TND')[1])
        }

        if(longueur==0) {
            document.getElementById("dates").children[0].innerHTML= "";
            document.getElementById("duree").children[0].innerHTML= "";
            document.getElementById("confirmButton").disabled = true;
            document.getElementById("container").style.display = "flex";
            document.getElementById("calculation").style.display = "none";
            document.getElementById("calculation").setAttribute('data-days',0);
            document.getElementById("calculation").setAttribute('data-total',0);
            document.getElementById("calculation").setAttribute('data-dateD',"");
            document.getElementById("calculation").setAttribute('data-dateF',"");
        }
        else if (longueur==10) {
            document.getElementById("dates").children[0].innerHTML= dateString;
            document.getElementById("duree").children[0].innerHTML= "1 jour";
            document.getElementById("confirmButton").disabled = false;
            document.getElementById("container").style.display="none";
            document.getElementById("periode").innerHTML="1 jour : "+dateString;
            document.getElementById('calcul1').children[0].innerHTML = prix_jour.toFixed(3)+'TND × 1 jour';
            document.getElementById('calcul1').children[1].innerHTML = prix_jour.toFixed(3);
            document.getElementById('calcul2').children[0].innerHTML = 'Frais de service';
            document.getElementById('calcul2').children[1].innerHTML = "15.000";
            document.getElementById('total').children[1].innerHTML = ((parseFloat(document.getElementById('calcul1').children[1].innerHTML))+15)+' TND';
            document.getElementById("calculation").setAttribute('data-days',1);
            document.getElementById("calculation").setAttribute('data-total',parseFloat(document.getElementById('calcul1').children[1].innerHTML)+15);
            document.getElementById("calculation").setAttribute('data-dateD',extraireDates(dateString)[0]);
            document.getElementById("calculation").setAttribute('data-dateF',extraireDates(dateString)[0]);
        }
        else {
            document.getElementById("dates").children[0].innerHTML=dateString;
            document.getElementById("duree").children[0].innerHTML= (nombreJoursEntreDeuxDates(dateString)+1)+" jours";
            document.getElementById("confirmButton").disabled = false;
            document.getElementById("container").style.display="none";
            let nbJours = nombreJoursEntreDeuxDates(dateString)+1;
            document.getElementById("calculation").setAttribute('data-days',nbJours);

            document.getElementById("periode").innerHTML= nbJours +" jours : "+dateString;
            if((nbJours>=31)&&(prix_mois!=null)) {
                document.getElementById('calcul1').children[0].innerHTML=prix_mois+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_mois*nbJours).toFixed(3);
            }
            else if ((nbJours>=31)&&(prix_semaine!=null)) {
                document.getElementById('calcul1').children[0].innerHTML=prix_semaine+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_semaine*nbJours).toFixed(3);
            }
            else if ((nbJours>=31)&&(prix_jour!=null)) {
                document.getElementById('calcul1').children[0].innerHTML=prix_jour+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_jour*nbJours).toFixed(3);
            }
            else if ((nbJours>=7)&&(prix_semaine!=null)) {
                document.getElementById('calcul1').children[0].innerHTML=prix_semaine+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_semaine*nbJours).toFixed(3);
            }
            else if ((nbJours>=7)&&(prix_jour!=null)) {
                document.getElementById('calcul1').children[0].innerHTML=prix_jour+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_jour*nbJours).toFixed(3);
            }
            else if (nbJours<7) {
                document.getElementById('calcul1').children[0].innerHTML=prix_jour+'TND × '+nbJours+' jours';
                document.getElementById('calcul1').children[1].innerHTML=(prix_jour*nbJours).toFixed(3);
            }
            document.getElementById('calcul2').children[0].innerHTML = 'Frais de service';
            document.getElementById('calcul2').children[1].innerHTML = "15.000";

            document.getElementById('total').children[1].innerHTML = ((parseFloat(document.getElementById('calcul1').children[1].innerHTML))+15)+' TND';
            document.getElementById("calculation").setAttribute('data-total',parseFloat(document.getElementById('calcul1').children[1].innerHTML)+15);
            document.getElementById("calculation").setAttribute('data-dateD',extraireDates(dateString)[0]);
            document.getElementById("calculation").setAttribute('data-dateF',extraireDates(dateString)[1]);
        }
    }
});



function nombreJoursEntreDeuxDates(datesString) {
    function convertDateStringToDate(dateString) {
        const [day, month, year] = dateString.split('/');
        return new Date(year, month - 1, day);
    }

    try {
        const [startDateString, endDateString] = datesString.split(' jusqu\'à ');
        const startDate = convertDateStringToDate(startDateString);
        const endDate = convertDateStringToDate(endDateString);
        const diffTime = Math.abs(endDate - startDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;   
    } catch (error) {
        
    }
}

function ouvrirPage2 (page1, page2) {
    page1.style.display = "none";
    page2.style.display = "flex";
}

function displayhidePopup() {
    let elt = document.getElementById("POPUP");
    if(elt.classList.contains('displayedPopup')) {
        elt.classList.remove('displayedPopup');
        elt.classList.add('hiddenPopup');
        setTimeout(() => {
            elt.style.display = "none";
        }, 400);
    }
    else if(elt.classList.contains('hiddenPopup')) {
        elt.classList.remove('hiddenPopup');
        elt.classList.add('displayedPopup');
        elt.style.display = "flex";
    }
}

function extraireDates(dateString) {
    var matches = dateString.match(/(\d{2}\/\d{2}\/\d{4})/g);
    return matches;
}