/**
 * Created by Kenan on 29/04/2017.
 */

var userEvents;

openAgendaWindow()

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

function deleteEvent(id){
    $('#loader').show();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var obj = {id :id}
    $.ajax({
        type: 'DELETE',
        url: "api/events",
        data: obj,
        beforeSend: function() {

        },
        success: function(data) {
            emptyView();
            openAgendaWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Fout bij het verwijderen van event');
        }
    });
}

function emptyView(){
    $('.content .container').empty();
}

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
        var select = $('<select></select>');
        var listOfWorkers = userEvents[i].invited.split('$');
        for(var j = 0; j < listOfWorkers.length-1; j++)
        {
            select.append('<option>'+listOfWorkers[j]+'</option>')
        }
        $(".table").append($("<tr><td>"+userEvents[i].organiser+"</td><td>"+userEvents[i].title+"</td><td>"+userEvents[i].description+"</td><td>"+userEvents[i].start_date+"</td><td>"+userEvents[i].end_date+"</td><td>"+userEvents[i].location+"</td><td><div id=row"+i+" class='cell'></div></td>"));
        $("#row"+i).append(select);
    }

    eventTable.show('normal');
}

function setAmountEventText(data){
    $('#numberOfEvents').text("Er zijn in totaal " + data.length + " evenement(en) in de agenda");
}