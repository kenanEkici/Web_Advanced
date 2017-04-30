<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <title>Login page</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script
        src="{!! asset('js/authentication/login.js') !!}">
    </script>
    <script
            src="{!! asset('js/authentication/register.js') !!}">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body >
{{ HTML::style('css/responsiveLogin.css') }}

<div class="loginscreen" id="container">
<form  class="inlogform">
    <p hidden id="url">
        <?php
        if(Session::has('errorNotLoggedIn')){
            $message = "This page is only accessible by authenticated users, please login.";
        }
        if(Session::has('errorAuthorisation')){
            $message = "You are not authorised for this page. Please login with a valid user or return to the homepage.";
        }
        echo Session::get('errorNotLoggedIn');
        ?>
    </p>
    <p id='message'><?php echo $message; ?></p>
    <h1 id='headline'>Login</h1>
    <span>Username</span>
    <input id='usernameInput' name='username' type='text'>
    <br>
    <span>Password</span>
    <input id='passwordInput' type='password' name='hash'>
    <br>
    <input type='button' onclick="login()" value='Login'>
    <input onclick="openRegister()" id="register" type="button" value="Register">
</form>
</div>
</body>
</html>
