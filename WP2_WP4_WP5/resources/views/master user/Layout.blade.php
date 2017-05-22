<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
    <style>
        #loader {
            border: 6px solid #f3f3f3; /* Light grey */
            border-top: 6px solid black; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script
            src="{!! asset('js/authentication/logout.js') !!}">
    </script>
    <script
            src="{!! asset('js/views/ajaxCrudEvents.js') !!}">
    </script>
    @yield('generateScript')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body >
<div class="container">
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Monkey Business</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a id="nav1" href="/home">Home</a></li>
                <li><a id="nav2" href="/events">Mijn events</a></li>
                <li><a id="nav4" href="/agenda">Agenda</a></li>
                <li><a id="nav4" href="javascript:void(0)" onclick="logout()">Log uit</a></li>
            </ul>
        </div>
    </div>
</nav>
    <div id="loader"></div>
<div class="jumbotron">
</div>
</div>
@yield('googleMaps')
</body>
</html>
