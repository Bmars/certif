<?php
session_start();

require("src/pageconnection.php");

if (isset($_SESSION['email'])) {
    header('Location:index.php');
}

if (isset($_POST['submit']))
{
// on vérifie que les champs ne sont pas vides
    if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) &&
        !empty($_POST['password_confirm']))
        {
        //on récupère les infos du form
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];
            if (strlen($pseudo) <= 16) 
            {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
                {
                    //test si le mdp est different de confirm le mdp
                    if ($password == $pass_confirm) 
                    {
                        // si les mdp sont ok, on hash le mdp

                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $database = getPDO();
                        $req = $database->prepare("SELECT * FROM login WHERE pseudo LIKE ? OR email LIKE ?");
                        $req->execute(array($pseudo, $email));
                        $email_verification = $req->fetchAll(PDO::FETCH_ASSOC);

                        if(count($email_verification) > 0) {
                            echo "pseudo ou mdp déjà utilisés";
                        } else {
                            $req = $database->prepare("INSERT INTO login(pseudo,email,password) VALUES(?,?,?)");
                            $req->execute([
                                $pseudo,
                                $email,
                                $hash
                                ]);
                                $succesMessage = "Votre compte à bien été créé !";
                                header('refresh:3;url=connection.php');

                        }





                        // foreach ($email_verification as $tableau) 
                        // { 
   
                        //     if ($tableau["pseudo"] === $pseudo) 
                        //     {
                        //         if ($tableau["email"] === $email) 
                        //         {
                        //         $req = $database->prepare("INSERT INTO login(pseudo,email,password) VALUES(?,?,?)");
                        //         $req->execute([
                        //             $pseudo,
                        //             $email,
                        //             $hash
                        //             ]);
                        //             $succesMessage = "Votre compte à bien été créé !";
                        //             header('refresh:3;url=connection.php');
                        //         } else {
                        //             $errorMessage = 'Ce pseudo est déjà utilisée..';
                        //         }
                        //     } else {
                        //         $errorMessage = 'Cet email est déjà utilisée..';
                        //     }
                        // }
                    } else {
                        $errorMessage = 'Les mots de passes ne correspondent pas...';
                    }
                } else {
                    $errorMessage = "Votre email n'est pas valide...";
                }
            } else {
                $errorMessage = 'Le pseudo est trop long...';
            }
    } else {
        $errorMessage = 'Veuillez remplir tous les champs...';
    }
}





//on test si email est utilise
// envoi de la requete


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certif</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <header>
        <h1>Inscription</h1>
    </header>
    <p id="info">Bienvenue sur mon site, pour en voir plus, inscrivez-vous. Sinon, <a href="connection.php">connectez-vous</a></p>
    <?php if (isset($errorMessage)) { ?> <p style="color: red; text-align: center;"><?= $errorMessage ?></p> <?php } ?>
    <?php if (isset($succesMessage)) { ?> <p style="color: green; text-align: center;"><?= $succesMessage ?></p> <?php } ?>
    <div id="form">
        <form method="post" action="inscription.php">
            <input type="text" name="pseudo" placeholder="pseudo" required></br>
            <input type="email" name="email" placeholder="email" required></br>
            <input type="password" name="password" placeholder="mot de passe" required></br>
            <input type="password" name="password_confirm" placeholder="confirme le mot de passe" required></br>
            <button type="submit" class="btn btn-primary" name="submit">Inscription</button>
        </form>
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

        <script src="main.js"></script>

</body>
</html>