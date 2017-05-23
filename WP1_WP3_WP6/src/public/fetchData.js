//variable for storing the retrieved events
var eventArr;

//to verify whether the extra register window has opened
var opened = false;

//URL van webserver
var url = "http://192.168.33.22";

//JAVASCRIPT FETCH statement om events binnen te halen
function fetchData() {
    var idValue = $('#idInput').val();
    var startDate = $('#startDateInput').val();
    var endDate = $('#endDateInput').val();

    if ($("#select").val() == "Event Id") {

        fetch(url + '/events/' + idValue, {
            method: 'get'
        }).then(function (response) {
            response.json().then(function (result) {
                eventArr = result;
                updateRows();
            }, function (err) {
                alert("Event not found")
            });
        }).catch(function (err) {
            alert(err);
        });
    }
    else if ($("#select").val() == "Owner Id") {
        fetch(url + '/events/person/' + idValue, {
            method: 'get'
        }).then(function (response) {
            response.json().then(function (result) {
                eventArr = result;
                updateRows();

            }, function (err) {
                alert(err)
            });
        }).catch(function (err) {
            alert(err);
        });

    }
    else if ($("#select").val() == "Between dates") {

        fetch(url + '/events/' + startDate + '/' + endDate, {
            method: 'get'
        }).then(function (response) {
            response.json().then(function (result) {
                eventArr = result;
                updateRows();

            }, function (err) {
                alert(err)
            });
        }).catch(function (err) {
            alert(err);
        });
    }
    else if ($("#select").val() == "Owner ID and between dates") {

        fetch(url + '/events/person/' + idValue + '/' + startDate + '/' + endDate,{
            method: 'get'
        }).then(function (response) {
            response.json().then(function (result) {
                //retrieve the results and store it locally
                eventArr = result;
                updateRows();

            }, function (err) {
                alert(err)
            });
        }).catch(function (err) {
            alert(err);
        });
    }
    else {
        alert("Error selecting a value")
    }
}

//clear the table and fill it with the entries of the fetched data from the api
function updateRows() {
    emptyView();
    for (var i = 0; i < eventArr.length; i++) {
        var row = $('<tr><td>' + eventArr[i].id +'</td><td>'+ eventArr[i].title + '</td><td>' + eventArr[i].organiser + '</td><td>' + eventArr[i].description + '</td><td>' + eventArr[i].start_date + '</td><td>' + eventArr[i].end_date + '</td><td>' + eventArr[i].location + '</td><td>' + eventArr[i].invited + '</td><td>' + eventArr[i].event_ownerId +'</td></tr>')
        $("#contentBody").append(row);
    }
}


//If a certain id is given, execute a put, else a post
function postData() {
    var event = {
        title: $("#title").val(),
        organiser: $("#organiser").val(),
        description: $("#description").val(),
        start_date: $("#startDate").val(),
        end_date: $("#endDate").val(),
        location: $("#location").val(),
        invited: $("#invited").val(),
        event_ownerId: $("#event_ownerId")
    };
    var id = $("#idInput").val();

    if (id !== "") {
        alert("put");
        var data = new FormData();
        data.append("json", JSON.stringify(event));

        fetch(url + "/events/" + id,
            {
                method: "POST",
                body: data
            });
    }
    else {
        alert("post");
        var data = new FormData();
        data.append("json", JSON.stringify(event));

        fetch(url + "/events",
            {
                method: "POST",
                body: data
            });
    }
}

//empty the table
function emptyView() {
    $("#contentBody").empty();
}

//Resize the header so the registration page is visible
function openExtraWindow() {
    if (opened) {
        $('#nav').css('height', 350);
        $('#hiddenForm').hide();
        $('#addButton').val("Voeg toe")
        opened = false;
    }
    else {
        $('#nav').css('height', 1050);
        $('#hiddenForm').show();
        $('#addButton').val("Annuleer")
        opened = true;
    }

}

