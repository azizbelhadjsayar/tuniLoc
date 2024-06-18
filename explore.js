// configuration MAP-------------------------------
var map = L.map('map').setView([33.8869, 9.5375], 6);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
      var bbox = e.geocode.bbox;
      var poly = L.polygon([
        bbox.getSouthEast(),
        bbox.getNorthEast(),
        bbox.getNorthWest(),
        bbox.getSouthWest()
      ]);
      map.fitBounds(poly.getBounds());
    })
    .addTo(map);





    map.on('moveend', filterItems);

    function filterItems() {
        var bounds = map.getBounds();
        //alert(bounds);  
        document.querySelectorAll('.item').forEach(function(item) {
          var lat = parseFloat(item.getAttribute('data-lat'));
          var lng = parseFloat(item.getAttribute('data-lng'));
          var isVisible = bounds.contains([lat, lng]);
          item.style.display = isVisible ? 'block' : 'none';
        });
    }
    filterItems();

    
    
    
    var markers = [];

    // Function to create markers for each item
    function createMarkers() {
      markers.forEach(marker => marker.remove()); // Remove existing markers

      document.querySelectorAll('.item').forEach(function(item) {
        var lat = parseFloat(item.getAttribute('data-lat'));
        var lng = parseFloat(item.getAttribute('data-lng'));
        var marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("<a href='article.php?id_article="+item.getAttribute('data-id')+"' target='_blank'>Voir l'article</a>");
        markers.push(marker); // Add marker to the array

        item.addEventListener('mouseover', function() {
          marker.setIcon(L.icon({iconUrl: 'images/red_marker.png'}));
        });

        item.addEventListener('mouseout', function() {
          marker.setIcon(L.icon({iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png'}));
        });
      });
    }

    // Initial creation of markers
    createMarkers();

    // Update markers when the map is moved
    map.on('moveend', createMarkers);
// configuration MAP-------------------------------





var globalAddress = null;

function getAddress(lat, lng, elt) {
    var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng;

    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.display_name) {
          var address = data.display_name;
          //globalAddress = address;
          elt.children[elt.children.length-2].innerHTML = address;
          console.log(address);
        } else {
          console.log('No address found for the coordinates.');
        }
      })
      .catch(error => console.error('Error:', error));
}


function chargerItems() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('liked')) {
        let liked = urlParams.get('liked');
        $.ajax({
            url: ('./phpScripts/getLikedItems.php?liked='+liked),
            type: 'GET',
            success: function(response) {
                if (response !== 'NULL') {
                    let result = JSON.parse(response);
                    result.forEach((element) => {
                        createAppendItem(element);
                        createMarkers();
                        filterItems();
                    });
                } else {
                    console.log(response);
                    document.getElementById('items').innerHTML = "<strong style='color:red; font-size:25px; width:100%; text-align:center; padding-top: 30px;'> Désolé, nous n'avons trouvé aucune correspondance </Strong>";
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
    } else {
        let titre = urlParams.get('titre');
        $.ajax({
            url: ('./phpScripts/getAllItems.php?titre='+titre),
            type: 'GET',
            success: function(response) {
                if (response !== 'NULL') {
                    let result = JSON.parse(response);
                    result.forEach((element) => {
                        createAppendItem(element);
                        createMarkers();
                        filterItems();
                    });
                } else {
                    console.log(response);
                    document.getElementById('items').innerHTML = "<strong style='color:red; font-size:25px; width:100%; text-align:center; padding-top: 30px;'> Désolé, nous n'avons trouvé aucune correspondance </Strong>";
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
    }
}

chargerItems();

getUserLikedItems();

function initialiserSplide (id) {
    var splide = new Splide( '#'+id, {
    type  : 'slide',
    rewind: true,
    });
    splide.mount();
}

function createAppendItem (item) {
    var divElement = document.createElement('div');
    divElement.addEventListener('click', function() {
        ouvrirArticle(divElement);
        event.stopPropagation();
    });

    divElement.classList.add('item');
    divElement.setAttribute('data-lat', item.lat);
    divElement.setAttribute('data-lng', item.lng);
    divElement.setAttribute('data-id', item.id);
    
    // Création de la section
    var sectionElement = document.createElement('section');
    sectionElement.setAttribute('id', 'image-carousel'+item.id);
    sectionElement.classList.add('splide');
    sectionElement.setAttribute('aria-label', 'Beautiful Images');
    
    // Création de la div splide__track
    var divTrackElement = document.createElement('div');
    divTrackElement.classList.add('splide__track');
    
    // Création de la liste ul
    var ulElement = document.createElement('ul');
    ulElement.classList.add('splide__list');

    if(item.photo1!=null) {
        var liElement = document.createElement('li');
        liElement.classList.add('splide__slide');
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', item.photo1);
        imgElement.setAttribute('alt', '');
        liElement.appendChild(imgElement);
        ulElement.appendChild(liElement);
    }

    if(item.photo2!=null) {
        var liElement = document.createElement('li');
        liElement.classList.add('splide__slide');
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', item.photo2);
        imgElement.setAttribute('alt', '');
        liElement.appendChild(imgElement);
        ulElement.appendChild(liElement);
    }

    if(item.photo3!=null) {
        var liElement = document.createElement('li');
        liElement.classList.add('splide__slide');
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', item.photo3);
        imgElement.setAttribute('alt', '');
        liElement.appendChild(imgElement);
        ulElement.appendChild(liElement);
    }

    if(item.photo4!=null) {
        var liElement = document.createElement('li');
        liElement.classList.add('splide__slide');
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', item.photo4);
        imgElement.setAttribute('alt', '');
        liElement.appendChild(imgElement);
        ulElement.appendChild(liElement);
    }

    if(item.photo5!=null) {
        var liElement = document.createElement('li');
        liElement.classList.add('splide__slide');
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', item.photo5);
        imgElement.setAttribute('alt', '');
        liElement.appendChild(imgElement);
        ulElement.appendChild(liElement);
    }

    divTrackElement.appendChild(ulElement);

    sectionElement.appendChild(divTrackElement);

    var h5Element = document.createElement('h5');
    h5Element.textContent = item.titre;
    var h6Element1 = document.createElement('h6');
    h6Element1.textContent = item.prenom;
    var h6Element2 = document.createElement('h4');
    h6Element2.textContent = (item.adresse != 'null') ? item.adresse : "";
    var pElement = document.createElement('p');
    pElement.textContent = item.prix_jour+"TND / jour";

    var heartIcon = document.createElement("i");
    heartIcon.classList.add("fa-solid");
    heartIcon.classList.add("fa-heart");

    heartIcon.addEventListener('click', function() {
        AddDeleteLike(divElement);
        event.stopPropagation();
    });
  
    divElement.appendChild(heartIcon);
    divElement.appendChild(sectionElement);
    divElement.appendChild(h5Element);
    divElement.appendChild(h6Element1);
    divElement.appendChild(h6Element2);
    divElement.appendChild(pElement);

    setTimeout(() => {
        initialiserSplide('image-carousel'+item.id);
        sectionElement.addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche la propagation de l'événement de clic aux éléments parents
        });
        if(arrayLikedResult.includes(parseInt(item.id))) heartIcon.classList.add('likedItem');
        else heartIcon.classList.add('unlikedItem');
    }, 300);
    document.getElementById("items").appendChild(divElement);
}


function loadLocation (elt) {
    getAddress(elt.getAttribute("data-lat"), elt.getAttribute("data-lng"), elt);
}

function AddDeleteLike(parentDiv) {
    let LikeIcon = parentDiv.children[0];
    if(LikeIcon.classList.contains('unlikedItem')) {
        $.ajax({
            url: './phpScripts/ajouterEnregistrement.php',
            type: 'GET',
            data: 'id_article='+parentDiv.getAttribute('data-id'),
            success: function(response) {
                if (response !== 'NULL') {
    
                } else {
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
        LikeIcon.classList.remove('unlikedItem');
        LikeIcon.classList.add('likedItem');
    }

    else if(LikeIcon.classList.contains('likedItem')) {
        $.ajax({
            url: './phpScripts/supprimerEnregistrement.php',
            type: 'GET',
            data: 'id_article='+parentDiv.getAttribute('data-id'),
            success: function(response) {
                if (response !== 'NULL') {
    
                } else {
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during AJAX request:', error);
            }
        });
        LikeIcon.classList.remove('likedItem');
        LikeIcon.classList.add('unlikedItem');
    }
}

let arrayLikedResult = [];


function getUserLikedItems() {
    $.ajax({
        url: './phpScripts/getUserLikedItems.php',
        type: 'GET',
        success: function(response) {
            if (response !== 'NULL') {
                let result = JSON.parse(response);
                for(var i in result)
                    arrayLikedResult.push(parseInt(result[i].id_article));
                // console.log(arrayResult.includes(10));
            } else {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error occurred during AJAX request:', error);
        }
    });
}


function ouvrirArticle(elt) {
    window.location.href = "article.php?id_article=" + encodeURIComponent(elt.getAttribute('data-id'));
}