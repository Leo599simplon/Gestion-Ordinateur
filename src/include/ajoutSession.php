<?php

require_once('config.php');

if(isset($_POST['buttonSession']))
{

            $debutSession = $_POST['debutSession'];
            $finSession = $_POST['finSession'];
            $choixOrdiString = $_POST['choixOrdi'];
            $choixVisiteurString = $_POST['choixVisiteur'];
            
            $choixOrdi= (int)$choixOrdiString;
            $choixVisiteur = (int)$choixVisiteurString;


            $sqlSession = "INSERT INTO Sessions (date_debut, date_fin, id_ordinateur, id_visiteur) VALUES (:date_debut, :date_fin, :id_ordinateur, :id_visiteur);";

            error_log(date('l jS \of F Y h:i:s A') . ": requete sql ok\r\n", 3, 'log.txt');

            $querySession = $pdo->prepare($sqlSession);

            $querySession->bindValue(':date_debut', $debutSession, PDO::PARAM_STR);
            $querySession->bindValue(':date_fin', $finSession, PDO::PARAM_STR);
            $querySession->bindValue(':id_ordinateur', $choixOrdi, PDO::PARAM_INT);
            $querySession->bindValue(':id_visiteur', $choixVisiteur, PDO::PARAM_INT);

            error_log(date('l jS \of F Y h:i:s A') . ": liaison param ok\r\n", 3, 'log.txt');


            $querySession->execute();

            error_log(date('l jS \of F Y h:i:s A') . ": execution query ok\r\n", 3, 'src/var/log.txt');

    header('Location: ../pages/welcome.php');
        }
    

