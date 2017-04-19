/**
 * Created by Kenan on 18/04/2017.
 */

//delete user by ID
function deleteUser(id)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var obj = {user_id :id}
    $.ajax({
        type: 'DELETE',
        url: "/users",
        data: obj,
        beforeSend: function() {

        },
        success: function(data) {
            alert("gebruiker verwijderd!")
        },
        error: function(xhr, textStatus, thrownError) {
            alert('foutje');
        }
    });
}

//Check if data is the same, return true
function checkData()
{
    $.ajax({
        type: 'GET',
        url: "/users/"+$("#username").val(),
        success: function(data)
        {
            if (JSON.stringify(data) === '[]')
            {
               post(true);
            }
            else
            {
               post(false,data[0].user_id);
            }

        },
        error: function()
        {

        }
    });
}

//raised by the send button on the blade view
function postData()
{
    checkData();
}

//update if false else create new entry
function post(updateOrCreate,id)
{
    if(updateOrCreate === true)
    {
        var user = {
            username: $("#username").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            hash: $("#hash").val(),
            role: $("#role").val(),
            address: $("#address").val()
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "/users",
            data: user,
            beforeSend: function() {

            },
            success: function(data) {
                alert("gebruiker toegevoegd!")
            },
            error: function(xhr, textStatus, thrownError) {
                alert('foutje');
            }
        });
    }
    else {
        var user = {
            user_id: id,
            username: $("#username").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            hash: $("#hash").val(),
            role: $("#role").val(),
            address: $("#address").val()
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'PUT',
            url: "/users",
            data: user,
            beforeSend: function() {

            },
            success: function(data) {
                alert("gebruiker updated! ")
            },
            error: function(xhr, textStatus, thrownError) {
                alert('foutje');
            }
        });
    }


}


