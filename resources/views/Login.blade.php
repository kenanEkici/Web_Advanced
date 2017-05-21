<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <title>Login page</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script
        src="{!! asset('js/authentication/login.js') !!}">
    </script>
    <script
            src="{!! asset('js/authentication/register.js') !!}">
    </script>
    <script
            src="{!! asset('js/authentication/registerValidation.js') !!}">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-image: url({{ URL::asset('images/login.jpeg') }})">
{{ HTML::style('css/loginSheet.css') }}
    <div >
        <div class="container">
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

                    <h2  id='headline'>Login op Monkey Business</h2><br>
                    <div class="form-group">
                        <label>Gebruikersnaam</label>
                        <input id='usernameInput' class="form-control" name='username' type='text'>
                    </div>
                    <div class="form-group">
                        <label>Wachtwoord</label>
                        <input id='passwordInput' class="form-control" type='password' name='hash'>
                    </div>
                    <div class="form-group">
                        <input value="Login" class="btn btn-secondary" type='button' onclick="login()">
                    </div>
                    <div class="form-group">
                        <input id="register" value="Register" class="btn btn-secondary" type="button" onclick="openRegister()">
                    </div>
                </form>
        </div>
    </div>
</body>
</html>
