/**
 * Created by Kenan on 18/04/2017.
 */
/**
 * Created by Kenan on 18/04/2017.
 */

//delete event by given ID with AJAX
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
        url: "/events",
        data: obj,
        beforeSend: function() {

        },
        success: function(data) {
            alert("event verwijderd!")
        },
        error: function(xhr, textStatus, thrownError) {
            alert('foutje');
        }
    });
}

//Check is the given data is the same and return true or false
function checkData()
{
    $.ajax({
        type: 'GET',
        url: "/users/"+$("#organiser").val(),
        success: function(userData)
        {
            $.ajax({
                type: 'GET',
                url: "/events/"+$("#title").val(),
                success: function(eventData)
                {

                    if (JSON.stringify(userData) === '[]' || JSON.stringify(eventData) === '[]')
                    {
                        post(true);
                    }
                    else if (userData[0].username === $("#organiser").val() && eventData[0].title === $("#title").val())
                    {
                        post(false,eventData[0].event_id);
                    }
                },
                error: function()
                {

                }
            });
        },
        error: function()
        {

        }
    });
}

//Raised by the button on the view
function postData()
{
    checkData();
}


//if true, create a new entry else update entry
function post(updateOrCreate,id)
{
    if(updateOrCreate === true)
    {
        var event = {
            organiser: $("#organiser").val(),
            title: $("#title").val(),
            description: $("#description").val(),
            start_date: $("#start").val(),
            end_date: $("#end").val(),
            location: $("#location").val(),
            invited: $("#invited").val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "/events",
            data: event,
            beforeSend: function() {

            },
            success: function(data) {
                alert("event toegevoegd!")
            },
            error: function(xhr, textStatus, thrownError) {
                alert('foutje');
            }
        });
    }
    else {
        var event = {
            event_id:id,
            organiser: $("#organiser").val(),
            title: $("#title").val(),
            description: $("#description").val(),
            start_date: $("#start").val(),
            end_date: $("#end").val(),
            location: $("#location").val(),
            invited: $("#invited").val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'PUT',
            url: "/events",
            data: event,
            beforeSend: function() {

            },
            success: function(data) {
                alert("event updated! ")
            },
            error: function(xhr, textStatus, thrownError) {
                alert('foutje');
            }
        });
    }


}


