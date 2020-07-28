<?php

session_start();

require("src/pageconnection.php");

 if (isset($_POST['submit'])) {
    $pseudo = $_SESSION['userPseudo'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];
    $confirmNewPassword = $_POST['confirm_password'];

    $database = getPDO();
    $req = $database->prepare("SELECT * FROM login WHERE pseudo = ?");
    $req->execute([$pseudo]);
    $row = $req->fetchAll();
    $recupHash = $row[0]["password"];

    if (password_verify($oldPassword, $recupHash)) {
        if ($newPassword == $confirmNewPassword) {

            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $request = $database->prepare("UPDATE login SET password = ? WHERE email = ?");
            $request->execute([
                $hash,
                $_SESSION['userEmail']
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

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
    <div style="display: flex;">
        <div style="display: inline-block; margin: 0 auto;">
            <input type="checkbox" class="checkbox" id="chk" />
            <label class="label" for="chk">
                <i class="fas fa-moon"></i>
                <i class="fas fa-sun"></i>
                <div class="ball"></div>
            </label>
        </div>
    </div>
<script src="main.js"></script>
</body>
</html>