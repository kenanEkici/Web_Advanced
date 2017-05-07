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

        copyForm = $('.container').clone();
        $('.container').append("<form > <br><h2 id='headline'>Register</h2><br>" +
            "<div class='form-group'><label>Username</label> <input class='form-control' id='usernameFrm' type='text'> </div>" +
            "<div class='form-group'><label>Password</label> <input class='form-control' id='passwordFrm' type='password'></div>"+
            "<div class='form-group'><label>First name</label> <input class='form-control' id='firstNameInput' type='text'></div>" +
            "<div class='form-group'><label>Last name</label> <input class='form-control' id='lastNameInput' type='text'></div>" +
            "<div class='form-group'><label>Department</label> <select class='form-control' id='optionFrm'><option>CEO</option><option>Administration</option><option>Accounting</option><option>Entertainment</option><option>Recreation</option><option>Admin</option></select><br></div>"+
            "<div class='form-group'><label>Address</label> <input class='form-control' type='text' id='address'></div>" +
            "<div><input onclick='registerUser()' class='btn btn-secondary' type='button' value='Register'></div></form>")
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

            closeRegister();

            $('#usernameInput').val(username);
            $('#passwordInput').val(password);
            $('#register').val("Register");
        },
        error: function(xhr, textStatus, thrownError) {
            alert('fout met het posten naar api/register/user');
        }
    });
}

function closeRegister()
{
    $('.container').replaceWith(copyForm);
    opened=false;
}



