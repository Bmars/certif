<?php
session_start();

require ("src/pageconnection.php");

if(isset($_POST['submit'])) {
    
    
        //variable
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $pass_confirm = $_POST['password_confirm'];

        if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && 
           !empty($_POST['password_confirm'])) {
        
    
        //test si le mdp est different de confirm le mdp
        if($password != $pass_confirm) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            echo "mot de passe different";
        } else{
            header("refresh:3;url=connection.php?success=1");
        }
    }
    
    //on test si email est utilise
    $req = $db->prepare("SELECT count(*) as numberEmail FROM login WHERE email = ?");
    $req->execute(array($email));
    
    while($email_verification = $req->fetch()){
       if($email_verification['numberEmail'] != 0){
           // header('location: ../?error=1&email=1')
          // var_dump('email');
        }
    }
// envoi de la requete
    $req =$db->prepare("INSERT INTO login(pseudo,email,password) VALUES(?,?,?)");
    $req->execute([
        $pseudo,
        $email,
        $hash
    ]);

    
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
    <header><h1>inscription</h1></header>
    
    
    <p>Bienvenue sur mon site, pour en voir plus, inscrivez-vous. Sinon, <a href="connection.php">connectez-vous</a></p>
    <?php
		 
			if(isset($_GET['error'])){
		 
				if(isset($_GET['pass'])){
					echo '<p id="error">Les mots de passe ne correspondent pas.</p>';
				}
				else if(isset($_GET['email'])){
					echo '<p id="error">Cette adresse email est déjà utilisée.</p>';
				}
			}
		//	else if(isset($_GET['success'])){
		//		echo '<p id="success">Inscription prise correctement en compte.</p>';
		//	}
		 
		?>
    <form method="post" action="inscription.php">   
    <input type="text" name="pseudo" placeholder="pseudo" required></br>
    <input type="email" name="email" placeholder="email"required></br>
    <input type="password" name="password" placeholder="mot de passe"required></br>
    <input type="password" name="password_confirm" placeholder="confirme le mot de passe"required></br>
    <button name="submit">inscription</button>




    </form>
</body>
</html>