<?php

require ("src/pageconnection.php");

if(isset($_POST['submit'])) {
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && 
    !empty($_POST['password_confirm'])) {
    
        //variable
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];
    
        //test si le mdp est different de confirm le mdp
        if($password != $pass_confirm) {
            echo "mot de passe different";
        }
    }
    
    //on test si email est utilise
    $req = $db->prepare("SELECT count(*) as numberEmail FROM login WHERE email = ?");
    $req->execute(array($email));
    
    while($email_verification = $req->fetch()){
       if($email_verification['numberEmail'] != 0){
           // header('location: ../?error=1&email=1')
           var_dump('email');
        }
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>certif</title>
    
</head>
<body>
    <h1>inscription</h1>
    <p>Bienvenue sur mon site, pour en voir plus, inscrivez-vous. Sinon, <a href="connection.php">connectez-vous</a></p>
    <form method="post" action="index.php">   
    <input type="text" name="pseudo" placeholder="pseudo"></br>
    <input type="email" name="email" placeholder="email"></br>
    <input type="password" name="password" placeholder="mot de passe"></br>
    <input type="password" name="password_confirm" placeholder="confirme le mot de passe"></br>
    <button name="submit">inscription</button>




    </form>
</body>
</html>