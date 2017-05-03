/**
 * Created by Kenan on 4/05/2017.
 */

function loadSessionData(callback)
{
    $.ajax({
        type: 'GET',
        url: 'api/sessionData',
        success: function (data) //after the session data is loaded
        {
            $.ajax({
                type: 'GET',
                url: 'api/users/' + data,
                success: function (data) { // after user data is loaded
                   return callback(data);
                }
            });
        }
    });
}
