/**
 * Created by Kenan on 20/05/2017.
 */

//ajax call om een event te posten (validation first)
function postEvent(){
    if (validateEverything())
    {
        //lijst gekozen door een gebruiken splitten dmv $
        //zodat we deze in de backend ook kunnen splitsen
        var listOfPeople = $('#listInvited').text().replace(/\n/g, "$");

        var event = {
            organiser: $("#organiserInput").val(),
            event_ownerId: userData.id,
            title: $("#titleInput").val(),
            description: $("#descriptionInput").val(),
            start_date: $("#startDateInput").val(),
            end_date: $("#endDateInput").val(),
            location: getMarkerLocation(),
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
                location.reload();
            },
            error: function(xhr, textStatus, thrownError) {
                alert("Voer alle velden correct in!")
            }
        });
    }
}

//ajax call om een event te verwijderen adhv id
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
        success: function(data) {
            emptyView();
            openEventWindow();
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Fout bij het verwijderen van event');
        }
    });
}