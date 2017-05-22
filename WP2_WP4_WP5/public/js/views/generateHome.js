/**
 * Created by Kenan on 27/04/2017.
 */

//---------------------------SESSION VARIABLES

var userData;

//meldingen
var amountOfPersonalEvents;
var amountOfEventsInAgenda;

//laad sessiedata eerst, en genereer home view daarna
loadSessionData(function(data){
    userData = data;
    $.ajax({
        type:'GET',
        url:'api/events/user/'+userData.username,
        success:function(events)
        {
            amountOfPersonalEvents = events.length;
            $.ajax({
                type:'GET',
                url:'api/events',
                success:function(allEvents)
                {
                    amountOfEventsInAgenda = allEvents.length;
                    generateHomeView();
                    $('#loader').hide();
                }
            });
        }
    });
});

//actual generating of view with data in it
function generateHomeView(){
   var homeList = $('<h2 id="welcomeText"></h2><br>' +
            '<ul class="list-group">' +
            '<li class="list-group-item justify-content-between"><a href="/events"><span style="font-size: 15pt" >Bekijk je evenementen</span></a>' +
            '<span class="badge badge-default badge-pill">'+amountOfPersonalEvents+'</span>' +
            '</li>' +
            '<li class="list-group-item justify-content-between"><a href="/profile"><span style="font-size: 15pt">Bekijk of wijzig uw profiel</span></a>' +
            '</li>' +
            '<li class="list-group-item justify-content-between"><a href="/agenda"><span style="font-size: 15pt">Open de agenda</span></a>' +
            '<span class="badge badge-default badge-pill">'+amountOfEventsInAgenda+'</span>' +
            '</li>' +
        '</ul>').hide();

    $('.jumbotron').append(homeList);
    setWelcomeText(userData.username);
    homeList.show('normal');
    $('#loader').hide();
}

function setWelcomeText(data){
    $('#welcomeText').text("Welkom " + data);
}



