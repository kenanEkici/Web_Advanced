/**
 * Created by Kenan on 29/04/2017.
 */

var userEvents;

openAgendaWindow();

function openAgendaWindow()
{
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

function deleteEvent(id)
{
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

function emptyView()
{
    $('.content .container').empty();
}

function generateAgendaView()
{
    var eventTable = $("<h1 id='numberOfEvents'></h1> <div class='subContainer'><div class='wrapper'> <div class='table'> <div class='row header blue'> <div class='cell'>Organiser</div><div class='cell'>Title</div> <div class='cell'>Description</div><div class='cell'>Start date</div> <div class='cell'>End date</div><div class='cell'>Location</div> <div class='cell'>Assigned coworkers</div></div></div></div>").hide();

    $('.content .container').append(eventTable);
    for(var i = 0; i < userEvents.length; i++)
    {
        var select = $('<select></select>');
        var listOfWorkers = userEvents[i].invited.split('$');
        for(var j = 0; j < listOfWorkers.length-1; j++)
        {
            select.append('<option>'+listOfWorkers[j]+'</option>')
        }
        $(".table").append($("<div class='row'> <div class='cell'>"+userEvents[i].organiser+"</div><div class='cell'>"+userEvents[i].title+"</div><div class='cell'>"+userEvents[i].description+"</div><div class='cell'>"+userEvents[i].start_date+"</div><div class='cell'>"+userEvents[i].end_date+"</div><div class='cell'>"+userEvents[i].location+"</div><div id=row"+i+" class='cell'></div><div class='cell'><img id="+userEvents[i].id+"+ onclick='deleteEvent(this.id)' class='deleteButton' src='../../images/trash.png'></div></div>"));
        $("#row"+i).append(select);
    }

    eventTable.show('normal');
}

function setAmountEventText(data)
{
    $('#numberOfEvents').text("Er zijn in totaal " + data.length + " evenementen in de agenda");
}