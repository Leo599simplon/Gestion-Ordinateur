<?php

if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1") { // Si on est en local on utilise ces identifiants
    $serveur = "localhost";
    $dbname = "test";
    $user = "admin";
    $password = "test";
} else { // Sinon on utilise les identifiants de la BDD Heroku
    $serveur = "us-cdbr-east-03.cleardb.com";
    $dbname = "b86ba72a9788a4";
    $user = "13a4dfbb";
    $password = "heroku_99c077ce9940398";
}

try { // Connexion à la BDD
    $pdo = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log(date('l jS \of F Y h:i:s A') . ": Connexion à la base de données réussie\r\n", 3, '../var/log.txt');
} catch (Exception $e) { // Si erreur, on renvoi un message d'erreur
    error_log(date('l jS \of F Y h:i:s A') . ": Connexion à la base de données impossible\r\n", 3, '../var/log.txt');
    die('Erreur : ' . $e->getMessage());
}


