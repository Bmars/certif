<?php

require('src/pageconnection.php');

if(!empty($_POST['email']) && !empty($_POST['password'])){

    //variables
    $email =$_POST['email'];
    $password =$_POST['password'];

    //verification du mdp avec email
    $req = $db->prepare('SELECT * FROM login WHERE email = ?');
    $req->execute(array($email));
    while ($login = $req->fetch()){

        if($password == $login['password']){
            header('location:../connection.php?success=1');

        }
        
    }

    header('location:../connection.php?error=1');
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection</title>
</head>
<body>
    <h1>connection<h1>
<form method="post" action="index.php">   
    <input type="email" name="email" placeholder="email"required></br>
    <input type="password" name="password" placeholder="password"required></br>
    <p><label><input type="checkbox" name="connect">Connexion automatique</label></p>
    <button>connection</button>
    
</body>
</html>