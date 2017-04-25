<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script
            src="{!! asset('js/logout.js') !!}">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body >
{{ HTML::style('css/homepageMagic.css') }}
<header id="header">
    <div class="container">
        <h1>
           Monkey Business
        </h1>
        <div id="loader"></div>
        <nav id="nav">
            <ul>
                <li>
                    <a id="nav1" href="javascript:void(0)" onclick='generateHomeView()'>Home</a>
                </li>
                <li>
                   <div id="nav2"><a href="javascript:void(0)" onclick='openEventWindow()'>Mijn evenementen</a></div>
                </li>
                <li>
                   <div id="nav3"><a href="javascript:void(0)">Mijn profiel</a></div>
                </li>
                <li>
                    <div id="nav4"><a href="javascript:void(0)">Agenda</a></div>
                </li>
                <li>
                    <a id="nav5" href="javascript:void(0)" onclick="logout()">Log uit</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="content">
    <div class="container">
    </div>
</div>
<script
        src="{!! asset('js/generateViews.js') !!}">
</script>
</body>
</html>
