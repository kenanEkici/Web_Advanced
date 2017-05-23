/**
 * Created by Kenan on 29/04/2017.
 */

var userEvents;

//when the script is loaded, run this function to generate the agenda window
openAgendaWindow();

//ajax call to get all existing events
function openAgendaWindow(){
    $('#loader').show();
    $.ajax({
        type:'GET',
        url:'api/events',
        success:function(data)
        {
            userEvents = data;
            generateAgendaView();
            $('#loader').hide();
            setAmountEventText(data);
        }
    });
}

function emptyView(){
    $('.content .container').empty();
}

//generate actual view with the data in it
function generateAgendaView(){
    var eventTable =
        $('<h2 id="numberOfEvents"></h2><br><br>' +
            '<table id="eventsTable" class="table table-hover">' +
            '<thead><tr><th>Organiser</th><th>Title</th><th>Description</th><th>Start date</th><th>End date</th><th>Locations</th><th>Coworkers</th></tr></thead>' +
            '<tbody id="tableBody"></tbody>' +
            '</table>').hide();

    $('.jumbotron').append(eventTable);

    for(var i = 0; i < userEvents.length; i++)
    {
        sessionStorage.setItem("location"+i, userEvents[i].location);

        var select = $('<select></select>');
        var listOfWorkers = userEvents[i].invited.split('$');
        for(var j = 0; j < listOfWorkers.length-1; j++)
        {
            select.append('<option>'+listOfWorkers[j]+'</option>')
        }
        $(".table").append($("<tr><td>"+userEvents[i].organiser+"</td><td>"+userEvents[i].title+"</td><td>"+userEvents[i].description+"</td><td>"+userEvents[i].start_date+"</td><td>"+userEvents[i].end_date+"</td><td><input class='btn btn-primary btn-sm' data-toggle='modal' data-target='#googleMapsModal' type='button' id=location"+i+" onclick='showMapsWindow(this.id)' value='Bekijk locatie'></td><td><div id=row"+i+" class='cell'></div></td>"));
        $("#row"+i).append(select);
    }

    eventTable.show('normal');
}

function setAmountEventText(data){
    $('#numberOfEvents').text("Er zijn in totaal " + data.length + " evenement(en) in de agenda");
}