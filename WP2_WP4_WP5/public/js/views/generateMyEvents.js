/**
 * Created by Kenan on 29/04/2017.
 */

var userData;
var userEvents;

//laad sessie data eerst
loadSessionData(function(data){
    userData = data;
    openEventWindow()
});

//haal de juiste events binnen
function openEventWindow(){
    $('#loader').show();
    $.ajax({
        type:'GET',
        url:'api/events/user/'+userData.username,
        success:function(data)
        {
            userEvents = data;
            generateEventView();
            $('#loader').hide();
        }
    });
}

//genereer view
function generateEventView(){
    var eventTable =
        $('<h2 id="numberOfEvents"></h2><br><br>' +
        '<table id="eventsTable" class="table table-hover">' +
            '<thead><tr><th>Organiser</th><th>Title</th><th>Description</th><th>Start date</th><th>End date</th><th>Locations</th><th>Coworkers</th></tr></thead>' +
            '<tbody id="tableBody"></tbody>' +
        '</table>').hide();

    $('.jumbotron').append(eventTable);

    for(var i = 0; i < userEvents.length; i++)
    {
        //HTML5 storage
        sessionStorage.setItem("location"+i, userEvents[i].location);

        var select = $('<select></select>');
        var listOfWorkers = userEvents[i].invited.split('$');
        for(var j = 0; j < listOfWorkers.length-1; j++)
        {
           select.append('<option>'+listOfWorkers[j]+'</option>')
        }
        $(".table").append($("<tr><td>"+userEvents[i].organiser+"</td><td>"+userEvents[i].title+"</td><td>"+userEvents[i].description+"</td><td>"+userEvents[i].start_date+"</td><td>"+userEvents[i].end_date+"</td><td><input class='btn btn-primary btn-sm' data-toggle='modal' data-target='#googleMapsModal' type='button' id=location"+i+" onclick='showMapsWindow(this.id)' value='Bekijk locatie'></td><td><div id=row"+i+" class='cell'></div></td> <td><a href='javascript:void()'><img onclick='deleteEvent(this.id)' id="+userEvents[i].id+"+ class='deleteButton' style='height: 25px; width:25px;' src='../../images/trash.png'></a></td>"));
        $("#row"+i).append(select);
    }
    setAmountEventText(userEvents);

    var form = $("<br><br><br><br><h2>Voeg een event toe</h2><br><h5 id='errorEvent'></h5><br><form>" +
        "<div class='form-group'><label>Organiser</label><input onblur='validateOrganiser()' class='form-control' id='organiserInput' placeholder='In geval van meeting vul eigen naam' type='text'></div>" +
        "<div class='form-group'><label>Title</label><input class='form-control' onblur='validateTitle()' id='titleInput' type='text'></div>" +
        "<div class='form-group'><label>Start date</label><input class='form-control' onblur='validateStartDate()'  id='startDateInput' type='datetime-local'></div>" +
        "<div class='form-group'><label>End date</label><input class='form-control' onblur='validateEndDate()'  id='endDateInput' type='datetime-local'></div>" +
        "<div class='form-group'><label>Location</label><br/><span id='mapsIndicatie'>Selecteer een locatie door op de google maps venster te klikken</span><div id='map'></div></div>" +
        "<div class='form-group'><label>Coworkers</label><input class='form-control' placeholder='Search and select coworkers' id='coWorkersInput' onkeyup='findReference(this.value)' type='search'></div><div id='resultBoxQuery'></div><br><br><br>" +
        "<div class='form-group'><label>Added coworkers</label><br><ul class='list-group' style='display:inline-block' id='listInvited'></ul></div>"+
        "<div class='form-group'><label>Description</label><textarea class='form-control' onblur='validateDescription()'  rows='10' id='descriptionInput'></textarea></div>" +
        "<div class='form-group'><input type='button' class='btn btn-secondary' value='Voeg toe' onclick='postEvent()'></div></form></form>").hide();
    $('.jumbotron').append(form);

    eventTable.show('normal');
    form.show('normal');

    $("#errorEvent").css("color", "#DD2C00");
}

function setAmountEventText(data){
    $('#numberOfEvents').text("U heeft in totaal " + data.length + " evenement(en) in uw planning");
}

//api call om een gebruiker op te zoeken adhv zoekopdrachten (mini-google-search)
function findReference(searchkey){
    $.ajax({
       type:'GET',
        url:'api/users/query/'+searchkey,
        success: function(data)
        {
            var resultBox = $('#resultBoxQuery');
            if (data==""){
                resultBox.empty();
                var resultBar = $('<select></select>');
                resultBar.append($('<option onclick="">' + 'No results found' +'</option>'));
                resultBox.append(resultBar);
            }
            else
            {
                resultBox.show();
                resultBox.empty();
                var resultBar = $('<select class="custom-select" id="coWorkersList" onclick="changeList()"></select>');

                for(var i =0; i< data.length; i++)
                {
                    resultBar.append($("<option id=" + data[i].username+ ">" + data[i].first_name + ' ' + data[i].last_name + '</option>'));
                }
                resultBox.append(resultBar);
            }
        }
    });
}

function changeList() {
    var username = $("#coWorkersList").find('option:selected').attr('id');
    $('#resultBoxQuery').hide();
    $('#listInvited').append('<li class="list-group-item list-group-item-success">'+username+'\n'+'</li>');
}

function emptyView(){
    $('.jumbotron').empty();
}






