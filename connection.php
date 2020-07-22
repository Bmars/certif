<?php

require('src/pageconnection.php');

if(isset($_GET['success'])){
    echo '<p id="success">Inscription prise correctement en compte.</p>';
}

if (isset($_POST['submit'])) {
 
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    
        
            
    if ((!empty($email)) && (!empty($password))) {

            

        $database = getPDO();
        $requestUser = $database->prepare("SELECT * FROM login WHERE email = ?");
        $requestUser->execute([$email]);
        $userCount = $requestUser->rowCount();
        if ($userCount == 1) {
                
            $userInfo = $requestUser->fetch();
            if ($userInfo && password_verify($password, $userInfo['user_password']))
                    {
                    $_SESSION['userID'] = $userInfo['id'];
                    $_SESSION['userPseudo'] = $userInfo['pseudo'];
                    $_SESSION['userEmail'] = $userInfo['email'];
                    $_SESSION['userPassword'] = $userInfo['password'];
                    $_SESSION['userRegisterDate'] = $userInfo['registerdate'];
                    $succesMessage = 'Bravo, vous êtes maintenant connecté !';
                    die("password match");
                    header('refresh:3;url=index.php');
            } else {
                die("password don't match");

                $errorMessage = 'Mauvais mot de passe';
            }        
        } else {
            die("no user");

            $errorMessage = 'Email incorrect!';
        }
    } else {
        die("field error");

        $errorMessage = 'Veuillez remplir tous les champs..';
    }
        
} 




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
</head>
<body>
    <h1>Connection<h1>
<form method="post" action="connection.php">   
    <input type="email" name="email" placeholder="email"required></br>
    <input type="password" name="password" placeholder="password"required></br>
    <p><label><input type="checkbox" name="connect">Connexion automatique</label></p>
    <button name="submit">Connection</button>
    
</body>
</html>