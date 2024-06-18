$(document).ready(function(){
    $('#inscriptionForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: './phpScripts/addUser.php',
            type: 'POST',
            data: formData,
            success: function(response){
                var result = JSON.parse(response);
                if(result.message=="Utilisateur est ajouté avec succès") {
                    console.log(result.message);
                    let status = document.getElementById("status");
                    status.style.display="block";
                    if(status.classList.contains("statusError"))
                        status.classList.remove("statusError");
                    if(!status.classList.contains("statusSuccess"))
                        status.classList.toggle("statusSuccess");
                    status.innerHTML=result.message;
                    displayToast("success",result.message, 1500);
                    setTimeout(() => {
                        window.location.href='profile.php';
                    }, 1500);
                }
                else {
                    console.log(result.message);
                    let status = document.getElementById("status");
                    status.style.display="block";
                    if(status.classList.contains("statusSuccess"))
                        status.classList.remove("statusSuccess");
                    if(!status.classList.contains("statusError"))
                        status.classList.toggle("statusError");
                    status.innerHTML=result.message;
                    displayToast("error",result.message, 2000);
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



function onlyNumbers (id) {
    elt=document.getElementById(id);
    elt.value = elt.value.replace(/[^0-9]/g, "");
}

function onlyCharacters (id) {
    elt=document.getElementById(id);
    elt.value = elt.value.replace(/[^a-zA-Z\s]/g, "");
}


// function getSessionData() {
//     $.ajax({
//         url: './phpScripts/getSessionInfos.php',
//         type: 'GET',
//         success: function(response) {
//             if (response !== 'NULL') {
//                 let result = JSON.parse(response);
//                 console.log(result.id+' - '+result.prenom+' - '+result.nom)
//             } else {
//                 console.log(response);
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error('Error occurred during AJAX request:', error);
//         }
//     });
// }


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