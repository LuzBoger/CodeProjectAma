<!-- Création de la page d'authentification -->
<!-- modif par david -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../Image/logo.png" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'authentification </title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <div style="background:pink;color:#333;position:fixed;right:0;bottom:0;z-index:99999999;font:1em arial;opacity:.9" id="ld"></div><script>setInterval(function(){if($(window).height()>=$(document).height()){$('#ld').text($(document).width()+' px & ' + $(window).height() + ' px');}else{$('#ld').text($(document).width()+17+' px & ' + $(window).height() + ' px');}},150);
    </script>
</head>
<body>
    <section>
        <div class="MiddleAuth">
            <form id="inscription" method="POST">
                <label for="name" class="label marginLabel1">Adresse mail : </label>
                <input type="email" name="email" id="email" class="TextInput"><br><br>

                <label for="password" class="label">Mot de passe : </label>
                <input type="password" name="password" id="password" class="TextInput">

                <a href="404.html">Mot de passe oublié ?</a><br><br>

                <input type="submit" value="S'identifier" class="PushSubmit">

                <img src="../Image/logo.png">
              </form>
        </div>
    </section>
    <script src="app.js"></script>
</body>
</html>