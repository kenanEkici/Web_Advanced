/**
 * Created by Kenan on 23/04/2017.
 */


//function to delete session(cookie)
function logout()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:'api/logout',
        success:function(data)
        {
            window.location.href = "/";
        }
    });
};