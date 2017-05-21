/**
 * Created by Kenan on 4/05/2017.
 */

var markers = [];

function loadSessionData(callback)
{
    $.ajax({
        type: 'GET',
        url: 'api/sessionData',
        success: function (data) //after the session data is loaded
        {
            $.ajax({
                type: 'GET',
                url: 'api/users/' + data,
                success: function (data) { // after user data is loaded
                   return callback(data);
                }
            });
        }
    });
}

//____________ INSPIRATIE UIT GOOGLE MAPS API DOCUMENTATION _______________

//MAPS definieren in een div
function initGoogleMaps()
{
    setTimeout(function(){
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 50.9333, lng: 5.3333},
            scrollwheel: true,
            zoom: 10,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false
        });

        map.addListener('click', function(e) {
            placeMarker(e.latLng, map);
        });
        }, 4000);
}

//voor een marker te plaatsen
function placeMarker(location,map) {
    deleteMarkers();
   marker = new google.maps.Marker({
            position: location,
            map: map
        });
   markers.push(marker);
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function clearMarkers() {
    setMapOnAll(null);
}

//om een alle markers te wissen
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

function getMarkerLocation()
{
    return markers[0].getPosition().lat() + "$" + markers[0].getPosition().lng();
}

function showMapsWindow(id)
{
    setTimeout(function(){
        var latLng = sessionStorage.getItem(id).split('$');

        $('#locationWindow').empty();
        $('#locationWindow').append($('<div id="locationView"></div>'));
        var map = new google.maps.Map(document.getElementById('locationView'), {
            center: {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])},
            scrollwheel: true,
            zoom: 10,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false
        });

        marker = new google.maps.Marker({
            position: {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])},
            map: map
        });
    },500)
}
