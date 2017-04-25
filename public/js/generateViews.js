/**
 * Created by Kenan on 25/04/2017.
 */

//---------------------------SESSION VARIABLES

var sessionData;
var userData;
var userEvents;
var allEvents;

// main

loadSessionData(); //page refresh

//----------------------------GET SESSION DATA (first thing that happens when the page loads)
//------------------------- AJAX CALL Functions to load user data (only happens at page refresh)

function loadSessionData() {
    $.ajax({
        type: 'GET',
        url: 'api/sessionData',
        success: function (data) //after the session data is loaded
        {
            sessionData = data.split('_'); //session data is the userID and role
            getCurrentUser();
        }
    });
}

function getCurrentUser()
{
    $.ajax({
        type: 'GET',
        url: 'api/users/' + sessionData[0],
        success: function (data) { // after user data is loaded
            userData = data;
            $('#loader').hide();
            generateHomeView();
        }
    });
}

function openEventWindow()
{
    $('#loader').show();
    $.ajax({
        type:'GET',
        url:'api/events',
        success:function(data)
        {
            userEvents = data;
            allPersonalEventDataLoaded();
        }
    });
}

function allPersonalEventDataLoaded()
{
    generateEventView();
    $('#loader').hide();
}

function openAgendaWindow()
{
    $('#loader').show();
}

function allEventsLoaded()
{
    $('#loader').hide();
}

//overwrite vars-----------------------

var loadedHome = false;
var loadedEvents = false;
var loadedProfile = false;
var loadedAgenda = false;


//--------------------- event handlers

function animateNav(id)
{
    $('#nav'+id).animate({height:'85px'},150, 'linear');
    $('#nav'+id).attr('style', 'background-color:#222;');
}

function deanimateNav(id)
{
    $('#nav'+id).animate({height:'55px'});
}

//--------------------_________________________________________________________

function generateHomeView()
{
    if (loadedHome== false)
    {
        loadedHome = true;
        loadedEvents = false;
        emptyView();
        var new_item = $("<h1 id='welcomeText'></h1> <div class='subContainer'>  <br> <h3 class='link' id='2' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk je evenementen of voeg een nieuwe evenement toe</h3>"
            + "<h3 class='link' id='3' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk of wijzig uw profiel</h3>"
            + "<h3 class='link' id='4' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk de agenda</h3></div>").hide();
        $('.content .container').append(new_item);
        setWelcomeText(userData.username);
        new_item.show('normal');
    }
}

function generateEventView()
{
    if (loadedEvents == false)
    {
        loadedHome = false;
        loadedEvents = true;
        emptyView();
        var eventTable = $("<h1 id='numberOfEvents'></h1> <div class='subContainer'><div class='wrapper'> <div class='table'> <div class='row header blue'> <div class='cell'>Organiser</div><div class='cell'>Title</div> <div class='cell'>Description</div><div class='cell'>Start date</div> <div class='cell'>End date</div><div class='cell'>Location</div> <div class='cell'>Assigned coworkers</div></div></div></div>").hide();
        var eventHeader1 = $("<h1 id='addEventLabel'>Voeg een event toe</h1> <div id='subContainer' class='subContainer'><div class='wrapper'> <div id='form1' class='table'> <div class='row header blue'> <div class='cell'>Organiser</div><div class='cell'>Title</div><div class='cell'>Start date</div> <div class='cell'>End date</div></div></div></div>").hide();
        var eventHeader2 = $("<div id='subContainer2'><div class='wrapper'> <div id='form2' class='table'><div class='row header blue'><div class='cell'>Location</div> <div class='cell'>Coworkers</div></div></div></div></div>").hide();
        var eventHeader3 = $("<div id='subContainer3'><div class='wrapper'> <div id='form3' class='table'><div class='row header blue'> <div class='cell'>Description</div></div></div></div></div>").hide();
        var eventHeader4 = $("<div class='wrapper'> <div id='form4' class='table'><div class='cell'><input onclick='postEvent()' value='Voeg event toe' type='button'></div></div></div>");

        $('.content .container').append(eventTable);
        for(var i = 0; i < userEvents.length; i++)
        {
            $(".table").append($("<div class='row'> <div class='cell'>"+userEvents[i].organiser+"</div><div class='cell'>"+userEvents[i].title+"</div><div class='cell'>"+userEvents[i].description+"</div><div class='cell'>"+userEvents[i].start_date+"</div><div class='cell'>"+userEvents[i].end_date+"</div><div class='cell'>"+userEvents[i].location+"</div><div class='cell'>"+userEvents[i].invited+"</div><div class='cell'><img id="+userEvents[i].event_id+"+ onclick='deleteEvent(this.id)' class='deleteButton' src='../images/trash.png'></div></div>"));
        }

        $('.content .container').append(eventHeader1);
        $('#subContainer').append(eventHeader2);
        $('#subContainer2').append(eventHeader3);
        $('#subContainer3').append(eventHeader4);
        $("#form1").append($("<div class='row'><div class='cell'><input id='organiserInput' placeholder='In geval van meeting vul eigen naam' type='text'></div><div class='cell'><input id='titleInput' type='text'></div><div class='cell'><input id='startDateInput' type='datetime-local'></div><div class='cell'><input id='endDateInput' type='datetime-local'></div></div>"));
        $("#form2").append($("<div class='row'><div class='cell'><input id='locationInput' type='text'></div><div class='cell'><input id='coWorkersInput' type='search'><select></select></div></div>"));
        $("#form3").append($("<div class='row'><div class='cell'><textarea rows='10' id='descriptionInput'></textarea></div></div>"));
        setAmountEventText(userEvents);
        eventTable.show('normal');
        eventHeader1.show('normal');
        eventHeader2.show('normal');
        eventHeader3.show('normal');
        eventHeader4.show('normal');
    }
}

function generateAgendaView()
{

}

function emptyView()
{
    $('.content .container').empty();
}

//--------------------________________________________________________________


function setWelcomeText(data)
{
    $('#welcomeText').text("Welkom " + data);
}

function setAmountEventText(data)
{
    $('#numberOfEvents').text("U heeft in totaal " + data.length + " evenementen in uw planning");
}


function postEvent()
{

    var event = {
        organiser: $("#organiserInput").val(),
        title: $("#titleInput").val(),
        description: $("#descriptionInput").val(),
        start_date: $("#startDateInput").val(),
        end_date: $("#endDateInput").val(),
        location: $("#locationInput").val(),
        invited: $("#coWorkersInput").val()
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "api/events",
        data: event,
        beforeSend: function() {

        },
        success: function(data) {
            loadedEvents = false;
            openEventWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert("Voer alle velden correct in!")
        }
    });
}

function deleteEvent(id)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var obj = {event_id :id}
    $.ajax({
        type: 'DELETE',
        url: "api/events",
        data: obj,
        beforeSend: function() {

        },
        success: function(data) {
            loadedEvents = false;
            openEventWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Fout bij het verwijderen van event');
        }
    });
}

