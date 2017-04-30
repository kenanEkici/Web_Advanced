/**
 * Created by Kenan on 21/04/2017.
 */
var copyForm;
var username;
var password;
var url;
var opened = false;

function openRegister()
{
    if (opened)
    {

        closeRegister();
        $('#register').val("Register");
    }
    else
    {

        opened=true;
        $('html, body').animate({ scrollTop: 500});
        $('#register').val("Close register");
        copyForm = $('#container').clone();
        $('#container').append("<form  class='inlogform'>  <p hidden id='url'> </p> <p id='message'><?php echo $message; ?></p> <h1 id='headline'>Register</h1>" +
            "<span>Username</span> <input id='usernameFrm' type='text'>  <br>  <span>Password</span> <input id='passwordFrm' type='password'><br>"
            + " <span>First name</span> <input id='firstNameInput' type='text'><br><span>Last name</span> <input id='lastNameInput' type='text'><br> <span>Department</span> <select id='optionFrm'><option>CEO</option><option>Administration</option><option>Accounting</option><option>Entertainment</option><option>Recreation</option><option>Admin</option></select><br>"
            +"<br>  <span>Address</span> <input type='text' id='address'>  <br><input onclick='registerUser()' type='button' value='Register'> </form>")

    }
}

function registerUser()
{
    var user = {
        username: $("#usernameFrm").val(),
        first_name: $("#firstNameInput").val(),
        last_name: $("#lastNameInput").val(),
        hash: $("#passwordFrm").val(),
        role: $("#optionFrm").val(),
        address: $("#address").val()
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "api/register/user",
        data: user,
        success: function(data) {
            alert("gebruiker toegevoegd!")
            username = $("#usernameFrm").val();
            password = $("#passwordFrm").val();
            $('#container').replaceWith(copyForm);
            $('#usernameInput').val(username);
            $('#passwordInput').val(password);
        },
        error: function(xhr, textStatus, thrownError) {
            alert('fout met het posten naar api/register/user');
        }
    });
}

function closeRegister()
{
    $('#container').replaceWith(copyForm);
    opened=false;
}
