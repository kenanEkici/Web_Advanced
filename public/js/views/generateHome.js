/**
 * Created by Kenan on 27/04/2017.
 */

//---------------------------SESSION VARIABLES

var userData;

loadSessionData(function(data)
{
    userData = data;
    generateHomeView();
});

function generateHomeView()
{
    var new_item = $("<h1 id='welcomeText'></h1> <div class='subContainer'>  <br> <h3 class='link' id='2' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk je evenementen of voeg een nieuwe evenement toe</h3>"
        + "<h3 class='link' id='3' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk of wijzig uw profiel</h3>"
        + "<h3 class='link' id='4' onmouseleave='deanimateNav(this.id)' onmouseenter='animateNav(this.id)'>Bekijk de agenda</h3></div>").hide();
    $('.content .container').append(new_item);
    setWelcomeText(userData.username);
    new_item.show('normal');
    $('#loader').hide();
}

function setWelcomeText(data)
{
    $('#welcomeText').text("Welkom " + data);
}

function animateNav(id)
{
    $('#nav'+id).animate({height:'85px'},150, 'linear');
    $('#nav'+id).attr('style', 'background-color:#222;');
}

function deanimateNav(id)
{
    $('#nav'+id).animate({height:'55px'});
}




