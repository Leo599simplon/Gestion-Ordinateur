<?php

try { // Connexion à la BDD
    $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'admin', 'test', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) { // Si erreur, on renvoi un message d'erreur
    die('Erreur : ' . $e->getMessage());
}

?>
