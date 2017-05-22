/**
 * Created by Kenan on 20/05/2017.
 */

var successOrganiser = false;
var successTitle = false;
var successLocation = true;
var successDescription = false;
var successStartDate = false;
var successEndDate = false;

//geen speciale tekens enkel letters (niet hoofdlettergevoelig) en cijfers toegelaten en min. 4 karakters max 15
function validateOrganiser()
{
    if ($("#organiserInput").val().match(/^[A-Za-z ]|[0-9]+/) && $("#organiserInput").val().length >= 4 && $("#organiserInput").val().length <= 15)
    {
        successOrganiser = true;
        emptyErrMess();
    }
    else
    {
        $("#errorEvent").text("Organiser moet minimum 4 karakters bevatten en mag maximum 15. (geen speciale tekens)");
    }
}

//geen speciale tekens enkel letters (niet hoofdlettergevoelig) en cijfers toegelaten en min. 6 karakters max 20
function validateTitle()
{
    if ($("#titleInput").val().match(/^[A-Za-z ]|[0-9]+/) && $("#titleInput").val().length >= 4 && $("#titleInput").val().length <= 20)
    {
        successTitle = true;
        emptyErrMess();
    }
    else
    {
        $("#errorEvent").text("Titel moet minimum 4 karakters bevatten en mag maximum 15. (geen speciale tekens)");
    }
}

//geen speciale tekens enkel letters en cijfers toegelaten en min. 4 karakters max 50
function validateLocation()
{
    if (getMarkerLocation() != "")
    {
        emptyErrMess();
        successLocation = true;
    }
    else
    {
        $("#errorEvent").text("Kies een locatie!");
    }
}

//min. 4 karakters max 600
function validateDescription()
{
    if ($("#descriptionInput").val().length >= 4 &&  $("#descriptionInput").val().length <= 600 )
    {
        successDescription = true;
        emptyErrMess();
    }
    else
    {
        $("#errorEvent").text("Vul een correcte beschrijving in van minimum 4 en maximum 600 karakters");
    }
}

//moet ingevuld zijn
function validateStartDate()
{
    if ($("#startDateInput").val() != "")
    {
        successStartDate = true;
        emptyErrMess();
    }
    else
    {
        $("#errorEvent").text("Geef een startdatum");
    }
}

//moet ingevuld zijn
function validateEndDate()
{
    if ($("#endDateInput").val() != "")
    {
        successEndDate = true;
        emptyErrMess();
    }
    else
    {
        $("#errorEvent").text("Geef een einddatum");
    }
}

function validateEverything()
{
    validateLocation();

    if (successTitle && successOrganiser && successStartDate && successEndDate && successLocation && successDescription)
    {
        return true;
    }
    else
    {
        window.scrollTo(300, 0);
        $("#errorEvent").text("Vul alles correct in!");
    }
}

function emptyErrMess()
{
    $("#errorEvent").text("");
}


