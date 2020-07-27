<?php
// params de PDO : host dbname user password
// host=localhost dbname=nom_de_ta_bdd 

//$db = new PDO('mysql:host=localhost;dbname=crud;charset=UTF8', 'root','');


/**
     * Connexion à la base de données.
     */
    function getPDO() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=crud;charset=UTF8', 'root', '');
            // $pdo->exec("SET CHARACTER SET utf8");
            return $pdo;
        } catch (PDOException $e) {
            var_dump($e);
        }
    }



?>