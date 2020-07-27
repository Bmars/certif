<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>accueil</title>
</head>
<body>
    <header>
        <h1>Bonjour bienvenue sur notre espace membre</h1>

        </header>
    <p id="para">Veuillez choisir les options suivantes</p>
    <div class="button">
    <!--<button type="submit" class="btn btn-dark" name="submit"><a href="inscription.php">Inscription</a></button></br>
    <button type="submit" class="btn btn-dark" name="submit"><a href="connection.php">connection</a></button>-->
    <a class="btn btn-primary" href="inscription.php" role="button">Inscription</a>
    <a class="btn btn-primary" href="connection.php" role="button">Connection</a>

    </div>
    <div>
        <input type="checkbox" class="checkbox" id="chk" />
        <label class="label" for="chk">
            <i class="fas fa-moon"></i>
            <i class="fas fa-sun"></i>
            <div class="ball"></div>
        </label>
    </div>
<script src="main.js"></script>
</body>
</html>