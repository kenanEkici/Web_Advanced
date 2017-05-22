/**
 * Created by Kenan on 21/04/2017.
 */

//login by sending credentials to server
//server response creates the right session cookie
//and allows us access to the system.
function login(){
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

//function for handling return URL's if there's any
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