<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Welkom</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body style="background-image: url({{asset('images/wallpaper2.jpg')}});">

{{ HTML::style('css/indexMagic.css') }}

<div class="header">
    <div id="row1"><span>Welcome to Event Manager</span></div>
</div>
<div class="container">
    <div id="row2">
        <input onclick="location.href='/login'" type="button" value="Login/Register">
        {{--{{ HTML::image('images/wallpaper2.jpg', 'a picture', array('class' => 'images')) }}--}}
    </div>
</div>
</body>
<footer class="footer">
    <div class="footerContainer"></div>
</footer>
</html>