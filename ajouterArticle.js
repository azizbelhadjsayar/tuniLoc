function loadImage(id) {
  let inputImage = document.getElementById(id);
  const [file] = inputImage.files;
  if (file) {
    let preview = document.getElementById(id+"preview");
    preview.style.backgroundSize = "cover";
    preview.style.backgroundImage = "URL("+URL.createObjectURL(file)+")";
  }
}

function onlyNumbers (id) {
  elt=document.getElementById(id);
  elt.value = elt.value.replace(/[^0-9]/g, "");
}

var globalAddress = null;

function getAddress(lat, lng) {
    var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.display_name) {
          var address = data.display_name;
          globalAddress = address;
          console.log(address);
        } else {
          console.log('No address found for the coordinates.');
        }
      })
      .catch(error => console.error('Error:', error));
}


document.getElementById('myForm').addEventListener('submit', function(event) {
  event.preventDefault();
  swal.fire({
    title: "Vous voulez vraiment ajouter cet article ?",
    text: "Annulez si vous voulez faire des changements.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Annuler',
    confirmButtonText: 'Oui, ajouter!',
  }).then((result) => {
    if (result.isConfirmed) {
      var formData = new FormData(this);
      for (const [key, value] of formData.entries()) {
        console.log(`Clé : ${key}, Valeur : ${value}`);
      }
      getAddress(document.getElementById("lat").value, document.getElementById("lng").value);
      setTimeout(() => {
        formData.append('adresse',globalAddress);
        $.ajax({
          url: "phpScripts/uploadItem.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            if(response==1) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "Merci pour l'ajout de votre article !",
                showConfirmButton: false,
                timer: 2500
              });
              setTimeout(() => {
                window.location.href='profile.php';
              }, 3000);
            }
            else {
                Swal.fire({
                position: "center",
                icon: "error",
                title: "Erreur lors de l'ajout de votre article",
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        });
      }, 1000);
      document.querySelectorAll(".imageIcon").forEach(element => {
      element.style.backgroundImage="url(./images/camera.png)"
      element.style.backgroundSize="50%";
    });
    this.reset();
    } else {
      // Handle cancellation
    }
  });
});



function showInfoPopup(info) {
  Swal.fire({
    text: info,
    icon: "info"
  });
}




