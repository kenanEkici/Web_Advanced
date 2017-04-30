/**
 * Created by Kenan on 29/04/2017.
 */

var sessionData;
var userData;

loadSessionData();

function openEventWindow()
{
    $('#loader').show();
    $.ajax({
        type:'GET',
        url:'api/events/user/'+userData.username,
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

function setAmountEventText(data)
{
    $('#numberOfEvents').text("U heeft in totaal " + data.length + " evenementen in uw planning");
}

function generateEventView()
{
        var eventTable = $("<h1 id='numberOfEvents'></h1> <div class='subContainer'><div class='wrapper'> <div class='table'> <div class='row header blue'> <div class='cell'>Organiser</div><div class='cell'>Title</div> <div class='cell'>Description</div><div class='cell'>Start date</div> <div class='cell'>End date</div><div class='cell'>Location</div> <div class='cell'>Assigned coworkers</div></div></div></div>").hide();
        var eventHeader1 = $("<h1 id='addEventLabel'>Voeg een event toe</h1> <div id='subContainer' class='subContainer'><div class='wrapper'> <div id='form1' class='table'> <div class='row header blue'> <div class='cell'>Organiser</div><div class='cell'>Title</div><div class='cell'>Start date</div> <div class='cell'>End date</div></div></div></div>").hide();
        var eventHeader2 = $("<div id='subContainer2'><div class='wrapper'> <div id='form2' class='table'><div class='row header blue'><div class='cell'>Location</div> <div class='cell'>Coworkers</div></div></div></div></div>").hide();
        var eventHeader3 = $("<div id='subContainer3'><div class='wrapper'> <div id='form3' class='table'><div class='row header blue'> <div class='cell'>Coworkers selected for the event</div></div></div></div></div>").hide();
        var eventHeader4 = $("<div id='subContainer4'><div class='wrapper'> <div id='form4' class='table'><div class='row header blue'> <div class='cell'>Description</div></div></div></div></div>").hide();
        var eventHeader5 = $("<div class='wrapper'> <div id='form5' class='table'><div class='cell'><input onclick='postEvent()' value='Voeg event toe' type='button'></div></div></div>");

        $('.content .container').append(eventTable);
        for(var i = 0; i < userEvents.length; i++)
        {
            var select = $('<select></select>');
            var listOfWorkers = userEvents[i].invited.split('$');
            for(var j = 0; j < listOfWorkers.length-1; j++)
            {
                select.append('<option>'+listOfWorkers[j]+'</option>')
            }
            $(".table").append($("<div class='row'> <div class='cell'>"+userEvents[i].organiser+"</div><div class='cell'>"+userEvents[i].title+"</div><div class='cell'>"+userEvents[i].description+"</div><div class='cell'>"+userEvents[i].start_date+"</div><div class='cell'>"+userEvents[i].end_date+"</div><div class='cell'>"+userEvents[i].location+"</div><div id=row"+i+" class='cell'></div><div class='cell'><img id="+userEvents[i].event_id+"+ onclick='deleteEvent(this.id)' class='deleteButton' src='../../images/trash.png'></div></div>"));
            $("#row"+i).append(select);
        }

        $('.content .container').append(eventHeader1);
        $('#subContainer').append(eventHeader2);
        $('#subContainer2').append(eventHeader3);
        $('#subContainer3').append(eventHeader4);
        $('#subContainer4').append(eventHeader5);
        $("#form1").append($("<div class='row'><div class='cell'><input id='organiserInput' placeholder='In geval van meeting vul eigen naam' type='text'></div><div class='cell'><input id='titleInput' type='text'></div><div class='cell'><input id='startDateInput' type='datetime-local'></div><div class='cell'><input id='endDateInput' type='datetime-local'></div></div>"));
        $("#form2").append($("<div class='row'><div class='cell'><input id='locationInput' type='text'></div><div class='cell'><div><input placeholder='Search and select coworkers' id='coWorkersInput' onkeyup='findReference(this.value)' type='search'></div><div id='resultBoxQuery'></div></div></div>"));
        $("#form3").append($("<div class='row'><div class='cell'><ul style='display:inline-block' id='listInvited'></ul></div></div>"));
        $("#form4").append($("<div class='row'><div class='cell'><textarea rows='10' id='descriptionInput'></textarea></div></div>"));
        setAmountEventText(userEvents);
        eventTable.show('normal');
        eventHeader1.show('normal');
        eventHeader2.show('normal');
        eventHeader3.show('normal');
        eventHeader4.show('normal');
        eventHeader5.show('normal');
}

function findReference(searchkey)
{
    $.ajax({
       type:'GET',
        url:'api/users/query/'+searchkey,
        success: function(data)
        {
            if (data!=null && data!=[])
            {
                $('#resultBoxQuery').show();
                $('#resultBoxQuery').empty();
                var resultBar = $('<select style="display:inline-block; vertical-align:top; overflow:hidden; border:solid grey 1px; " size=' +data.length+'></select>');
                for(var i =0; i< data.length; i++)
                {
                    resultBar.append($("<option onclick='addToCoWorkerList(this.value,this.id)' id=" + data[i].username+ ">" + data[i].first_name + ' ' + data[i].last_name + '</option>'));
                }
                $('#resultBoxQuery').append(resultBar);
            }
            else if(data=="")
            {
                $('#resultBoxQuery').empty();
                var resultBar = $('<select style="display:inline-block; vertical-align:top; overflow:hidden; border:solid grey 1px; " size="1"></select>');
                resultBar.append($('<option onclick="">' + 'No results found' +'</option>'));
                $('#resultBoxQuery').append(resultBar);
            }
        }
    });
}

function addToCoWorkerList(value,id)
{
    $('#resultBoxQuery').hide();
    $('#listInvited').append('<li id=' + value +'>'+id+"\n"+'</li>');
}

function emptyView()
{
    $('.content .container').empty();
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
            emptyView();
            openEventWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Fout bij het verwijderen van event');
        }
    });
}


function postEvent()
{
    var listOfPeople = $('#listInvited').text().replace(/\n/g, "$");

    var event = {
        organiser: $("#organiserInput").val(),
        title: $("#titleInput").val(),
        description: $("#descriptionInput").val(),
        start_date: $("#startDateInput").val(),
        end_date: $("#endDateInput").val(),
        location: $("#locationInput").val(),
        invited: listOfPeople
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
            emptyView();
            openEventWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert("Voer alle velden correct in!")
        }
    });
}

function loadSessionData()
{
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
            openEventWindow();
        }
    });
}

