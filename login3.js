let session_id = null;
let session_prenom = null;
let session_nom = null;


$(document).ready(function(){
    $('#connexionForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './phpScripts/connectUser.php',
            type: 'POST',
            data: formData,
            success: function(response){
                var result = JSON.parse(response);
                if(result.message=="Connexion avec succès") {
                    console.log(result.message);
                    let status = document.getElementById("status");
                    status.style.display="block";
                    if(status.classList.contains("statusError"))
                        status.classList.remove("statusError");
                    if(!status.classList.contains("statusSuccess"))
                        status.classList.toggle("statusSuccess");
                    status.innerHTML=result.message;
                    // getSessionData();
                    // setTimeout(() => {
                    //     var valueToSend = session_id;
                    //     window.location.href = "profile.php?utilisateur=" + encodeURIComponent(valueToSend);
                    // }, 500);
                    displayToast("success", "Connecté avec succès", 1500);
                    setTimeout(() => {
                        if(result.type=="user")
                            window.location.href = "profile.php";
                        else
                            window.location.href = "admin.php";
                    }, 1500);
                }
                else {
                    displayToast("error", result.message);
                    let status = document.getElementById("status");
                    status.style.display="block";
                    if(status.classList.contains("statusSuccess"))
                        status.classList.remove("statusSuccess");
                    if(!status.classList.contains("statusError"))
                        status.classList.toggle("statusError");
                    status.innerHTML=result.message;
                    displayToast("error", result.message, 2000);
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

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