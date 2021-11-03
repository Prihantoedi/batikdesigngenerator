<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Batik Web App</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="css/login.css">
        <!------ Include the above in your HEAD tag ---------->
    </head>
    <body>

        <div class="wrapper fadeInDown">
            <div id="formContent">

                <!-- Title -->
                <div class="fadeIn first mt-1">
                    <h2> Batik Design Generator </h2>
                </div>

                <!-- Login Form -->
                <form method="post" action="processlogin.php">
                    <input type="text" id="username" class="fadeIn second" name="username" placeholder="username" value="">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" value="">
                    <input type="submit" name="submit" class="fadeIn fourth" value="Log In">
                </form>

                <!-- Remind Passowrd -->
                <div id="formFooter">
                <p class="text-center">Tidak punya akun? <a class="underlineHover" href="register.php">Register</a> </p>
                </div>

            </div>
        </div>
    </body>
</html>