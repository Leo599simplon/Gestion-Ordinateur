<?php
 require_once('config.php');

//ajout 

    if(isset($_POST)){
        if(isset($_POST['nom']) && !empty($_POST['nom']))
    {
        
                $nom = strip_tags($_POST['nom']);
    
                $sql = "INSERT INTO `Visiteurs` (`nom`) VALUES (:nom);";
    
                $query = $pdo->prepare($sql);
    
                $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    
    
                $query->execute();
    
            }
            elseif(isset($_POST['nomComp']) && !empty($_POST['nomComp']))
            {
                $nomComp = strip_tags($_POST['nomComp']);

                $sqlComp = "INSERT INTO `Ordinateurs` (`nom`) VALUES (:nomComp);";
    
                $queryComp = $pdo->prepare($sqlComp);
    
                $queryComp->bindValue(':nomComp', $nomComp, PDO::PARAM_STR);
    
    
                $queryComp->execute();
            }

    }





