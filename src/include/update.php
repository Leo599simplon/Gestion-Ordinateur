<?php

require_once('config.php');

if(isset($_POST)){
    if(isset($_POST['id']) && !empty($_POST['id'])
        && isset($_POST['nom']) && !empty($_POST['nom']))
       {
        $id = strip_tags($_GET['id']);
        $nom = strip_tags($_POST['nom']);

        $sql = "UPDATE `Visiteurs` SET `nom`=:nom WHERE `id_visiteur`=:id;";

        $query = $pdo->prepare($sql);

        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        header('Location: ../pages/welcome.php');


    }
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = strip_tags($_GET['id']);
    $sql = "SELECT * FROM `Visiteurs` WHERE `id_visiteur`=:id;";

    $query = $pdo->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch();
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style/style.css">

</head>


<body>


    <div class="container-fluid d-flex align-items-center justify-content-center">
        <img class="rounded-circle w-25" src="src/ressources/bot_icon.gif" alt="" />
    </div>
    </div>


    <div class="d-flex flex-column align-items-center container-fluid" id="loginDiv">
        <h2 class="py-5 mt-5">Modification du nom</h2>

        <form method="post">
            <div class="form-group mb-3">
            <label for="nom"></label>
              
            <input type="text" name="nom" id="nom" value="<?= $result['nom'] ?>">
                
            </div>
           
            <div class="form-group mb-3 pt-3 d-flex justify-content-center">
                <button class="btn btn-primary">Enregistrer</button>
                <input type="hidden" name="id" value="<?= $result['id_visiteur'] ?>">
            </div>
            </div>
        </form>
    </div>
</body>

</html>
