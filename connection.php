<?php

require('src/pageconnection.php');

// if(isset($_GET['success'])){
//     echo '<p id="success">Inscription prise correctement en compte.</p>';
// }

if (isset($_POST['submit'])) {
 
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    
        
            
    if ((!empty($email)) && (!empty($password))) {

            

        $db = getPDO();
        $requestUser = $db->prepare("SELECT * FROM login WHERE email = ?");
        $requestUser->execute([$email]);
        $userCount = $requestUser->rowCount();
        if ($userCount == 1) {
                
            $userInfo = $requestUser->fetch();
            if ($userInfo && password_verify($password, $userInfo['password']))
                    {
                    $_SESSION['userID'] = $userInfo['id'];
                    $_SESSION['userPseudo'] = $userInfo['pseudo'];
                    $_SESSION['userEmail'] = $userInfo['email'];
                    $_SESSION['userPassword'] = $userInfo['password'];
                    $_SESSION['userRegisterDate'] = $userInfo['registerdate'];
                    $succesMessage = 'Bravo, vous êtes maintenant connecté !';
                    header('refresh:3;url=index.php'); 
            } else {
                $errorMessage = 'Mauvais mot de passe';
            }        
        } else {
            $errorMessage = 'Email incorrect!';
        }
    } else {
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <header>
    <h1>Connection<h1>
</header>
        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
<form method="post" action="connection.php">   
    <input type="email" name="email" placeholder="email"required></br>
    <input type="password" name="password" placeholder="password"required></br>
    <p><label><input type="checkbox" name="connect">Connexion automatique</label></p>
    <button name="submit">Connection</button>
    
</body>
</html>