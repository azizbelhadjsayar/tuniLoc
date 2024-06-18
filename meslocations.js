function annulerDemande (elt) {
    let location_id = elt.parentNode.parentNode.getAttribute('data-id');
    
    swal.fire({
        title: "Vous voulez vraiement annuler cette demande ?",
        text: "Vous pouvez retourner en arrière en laissant la demande en attente de réponse",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, annuler la demande',
        cancelButtonText: 'Non',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './phpScripts/annulerDemande.php',
                type: 'GET',
                data: 'location_id='+location_id,
                success: function(response) {
                    if (response !== 'NULL') {
                        window.location.reload();
                    } else {

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred during AJAX request:', error);
                }
            });          
        } else {
          
        }
    });
}

function supprimerLocation(elt) {
    let location_id = elt.parentNode.parentNode.getAttribute('data-id');
    $.ajax({
        url: './phpScripts/supprimerLocation.php',
        type: 'GET',
        data: 'location_id='+location_id,
        success: function(response) {
            if (response !== 'NULL') {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Demande supprimée !",
                    showConfirmButton: false,
                    timer: 1500
                  });
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {

            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });          
}