<?php

session_start();

require("src/pageconnection.php");

 if (isset($_POST['submit'])) {
 
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];
    $confirmNewPassword = $_POST['confirm_password'];
 
    if ($_SESSION['userPassword'] == $oldPassword) {
        if ($newPassword == $confirmNewPassword) {

            $database = getPDO();
            $request = $database->prepare("UPDATE login SET password = ? WHERE email = ?");
            $request->execute([
                $newPassword,
                $_SESSION['email']
            ]);
            $succesMessage = 'Le mot de passe est maintenant modifié !';
            header('refresh:3;url=index.php');
 
        } else {
            $errorMessage = 'Les mots de passes ne sont pas identiques!';
        }
    } else {
        $errorMessage = 'Le mot de passe est incorrect..';
    }
 }
?>





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

    <div class="form-div text-center">
                <h3>Information</h3>
                <?php if (isset($_SESSION['userEmail'])) { ?>
                        <p>Bonjour, <?= $_SESSION['userPseudo'] ?> !</p>
                        <p>Email : <?= $_SESSION['userEmail'] ?></p>
                        <p>Inscrit le <?= $_SESSION['userRegisterDate'] ?></p>
                        <a href="deconnection.php"> Se Déconnecter</a>
                        <br>
                        <h3>Changer de mot de passe</h3>
                        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
                        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
                        <form method="post" action="">
 
                            <span>Ancien Mot de passe :</span><br>
                            <input type="password" name="old_password" placeholder="Ancien Mot de passe"><br>
 
                            <span>Nouveau Mot de passe :</span><br>
                            <input type="password" name="password" placeholder="Nouveau Mot de passe"><br><br>
 
                            <span>Confirmation du Nouveau Mot de passe :</span><br>
                            <input type="password" name="confirm_password" placeholder="Confirmation Mot de passe"><br><br>
 
                            <input type="submit" name="submit" value="Valider">
                        </form>
                       
                    <?php } else { ?>
                    <p>Vous n'êtes pas connecté !</p>
                <?php } ?>
        </div>
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