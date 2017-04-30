/**
 * Created by Kenan on 21/04/2017.
 */
function login()
{
    var username = $('#usernameInput').val();

    if (username !== "")
    {
        $.ajax({
            type: 'POST',
            url: "/api/login",
            data: {username: username, hash: $('#passwordInput').val()},
            success: function (success) {
                if (success === "pass") {
                    handleURL($('#url'))
                }
                else{
                    $('#message').text("Invalid username or password");
                }
            }
        });
    }
    else {
        $('#message').text("Please fill in your username");
    }
}
function handleURL(url){


    if (!$.trim(url.html()))
    {
        window.location.href = "/home";
    }
    else
    {
        window.location.href = url.text();
    }
}