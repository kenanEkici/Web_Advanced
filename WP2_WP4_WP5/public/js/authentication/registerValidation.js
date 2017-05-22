/**
 * Created by Kenan on 20/05/2017.
 */

var successUsername = false;
var successFirstname = false;
var successLastname = false;
var successAddress = false;
var successHash = false;

//geen speciale tekens enkel letters (niet hoofdlettergevoelig) en cijfers toegelaten en min. 4 karakters max 15
function validateUserName()
{
    if ($("#usernameFrm").val().match(/^[A-Za-z]|[0-9]+/) && $("#usernameFrm").val().length >= 4 && $("#usernameFrm").val().length <= 15)
    {
        checkUsernameExisting(function(val)
        {
            if (val)
            {
                successUsername = true;
                emptyErrMess();
            }
            else
            {
                $("#errorRegistration").text("Gebruikersnaam bestaat al.");
            }
        })

    }
    else
    {
        $("#errorRegistration").text("Gebruikersnaam moet minimum 4 karakters bevatten zonder speciale tekens");
    }
}

//geen speciale tekens enkel letters (niet hoofdlettergevoelig) en cijfers toegelaten en min. 6 karakters max 20
function validatePassword()
{
    if ($("#passwordFrm").val().match(/^[A-Za-z]|[0-9]+$/) && $("#passwordFrm").val().length >= 4 && $("#passwordFrm").val().length <= 20)
    {
        successHash = true;
        emptyErrMess();
    }
    else
    {
        $("#errorRegistration").text("Wachtwoord mag geen speciale tekens bevatten en moet minimum 6 karakters bevatten");
    }
}

//geen speciale tekens enkel letters en cijfers toegelaten en min. 4 karakters max 20
function validateFirstName()
{
    if ($("#firstNameInput").val().match(/^[A-Za-z]+$/) && $("#firstNameInput").val().length >= 4 && $("#firstNameInput").val().length <= 20 )
    {
        successFirstname = true;
        emptyErrMess();
    }
    else
    {
        $("#errorRegistration").text("Voornaam mag geen speciale karakters en cijfers bevatten");
    }
}

//geen speciale tekens enkel letters en cijfers toegelaten en min. 4 karakters max 40
function validateLastName()
{
    if ($("#lastNameInput").val().match(/^[A-Za-z]+$/) && $("#lastNameInput").val().length >= 4 &&  $("#lastNameInput").val().length <= 40 )
    {
        successLastname = true;
        emptyErrMess();
    }
    else
    {
        $("#errorRegistration").text("Achternaam mag geen speciale karakters en cijfers bevatten");
    }
}

//geen speciale tekens enkel letters en cijfers toegelaten en min. 4 karakters max 100
function validateAddress()
{
    if ($("#address").val().match(/^[A-Za-z]|[0-9]+$/) && $("#address").val().length >= 4 && $("#address").val().length <= 100 )
    {
        successAddress = true;
        emptyErrMess();
    }
    else
    {
        $("#errorRegistration").text("Adres mag niet leeg zijn");
    }
}

function validateEverything()
{
    if (successUsername && successFirstname && successLastname && successAddress && successHash)
    {
        return true;
    }
    else
    {
        $("#errorRegistration").text("Vul alles correct in!");
    }
}

function emptyErrMess()
{
    $("#errorRegistration").text("");
}

function checkUsernameExisting(val)
{
    var username = $("#usernameFrm").val();
    $.ajax({
        url:"api/users/"+username,
        type:"GET",
        success: function(data)
        {
            if (data == "")
            {
                return val(true);
            }
            else
            {
                if (data.username.toUpperCase().localeCompare(username.toUpperCase()) == 0)
                {
                    return val(false);
                }
            }
        }
    });
}







