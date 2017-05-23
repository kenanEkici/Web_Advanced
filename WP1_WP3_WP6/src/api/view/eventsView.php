<?php

echo
"<html>
<head>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
    <link rel='stylesheet' href='/src/public/magicLayout.css'>
    <script src='/src/public/fetchData.js'></script>
</head>
<body>

<div id='nav'>
    <h3>Zoeken naar event</h3>

    <label>Zoeken op: </label><select id='select'><option>Event Id</option><option>Owner Id</option><option>Between dates</option><option>Owner ID and between dates</option></select>
    <input id='idInput' type='number' placeholder='Geef ID in' min='1' max='999'>
<div id='dateDiv'>
    <label>Startdatum:<input id='startDateInput' type='datetime'></label>
    <label>Einddatum:<input id='endDateInput' type='datetime'></label>
</div>

<input id='fetchButton' onclick='fetchData()' value='Haal events op' type='button'>
<input id='addButton' onclick='openExtraWindow()' value='Voeg events toe' type='button'>

    <form method='post' name='event' action='/events'>
            <div id='hiddenForm' hidden >
            <label>Titel</label>
            <input id='title'  type='text'><br>
            <label >Organiser</label>
            <input id='organiser' type='text'><br>
            <label>Description</label>
            <input id='description' type='text'><br>
            <label>Start Date</label>
            <input id='startDate' type='datetime'><br>
            <label>End Date</label>
            <input id='endDate' type='datetime'><br>
            <label>Location</label>
            <input id='location' type='text'><br>
            <label>Invited Coworkers</label>
            <input id='invited' type='text'><br>
            <label>Event Owner Id</label>
            <input id='event_ownerId' type='text'>
            <input type='button' onclick='postData()' value='Voeg toe'>
            
            </div>
    </form>
</div>

<div class='container'>
    <table>
         <thead><tr>
            <th scope=\"col\">Event ID</th>
            <th>Title</th>
            <th>Organiser</th>
            <th>Description</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Location</th>
            <th>Invited coworkers</th>
            <th>Event Owner Id</th>
         </tr></thead>
         <tbody id='contentBody'>            
         </tbody>        
    </table>
</div>
</body>
</html>";