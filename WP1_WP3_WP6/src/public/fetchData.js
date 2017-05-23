var eventArr;
var opened = false;
var url = "http://192.168.33.22";

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
        //alert('Owner ID and between dates : startDate = ' + startDate + ' endDate : ' + endDate + ' personId: ' + idValue);
        alert(url + '/events/person/' + idValue + '/' + startDate + '/' + endDate);
        fetch(url + '/events/person/' + idValue + '/' + startDate + '/' + endDate,{
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
    else {
        alert("Error selecting a value")
    }
}

function updateRows() {
    emptyView();
    for (var i = 0; i < eventArr.length; i++) {
        var row = $('<tr><td>' + eventArr[i].id +'</td><td>'+ eventArr[i].title + '</td><td>' + eventArr[i].organiser + '</td><td>' + eventArr[i].description + '</td><td>' + eventArr[i].start_date + '</td><td>' + eventArr[i].end_date + '</td><td>' + eventArr[i].location + '</td><td>' + eventArr[i].invited + '</td><td>' + eventArr[i].event_ownerId +'</td></tr>')
        $("#contentBody").append(row);
    }
}


// Posting and Putting data
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

function emptyView() {
    $("#contentBody").empty();
}

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

