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
    <script type="text/javascript">
       $.ajax({
           type:'GET',
           url:'api/sessionData',
           success: function(data)
           {

           }
       })
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body >
{{ HTML::style('css/responsiveLogin.css') }}

<input type="button" onclick="logout()" value="Logout">
</body>
</html>
