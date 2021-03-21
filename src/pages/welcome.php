<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


include "../include/add.php";
include "../include/ajoutSession.php";





// On écrit notre requête
$sql = 'SELECT * FROM `Visiteurs`';

// On prépare la requête
$query = $pdo->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);



// Même chose pour les ordinateurs
$sqlComp = 'SELECT * FROM `Ordinateurs`';

$queryComp = $pdo->prepare($sqlComp);


$queryComp->execute();

$resultComp = $queryComp->fetchAll(PDO::FETCH_ASSOC);


// Voir les sessions actives
$sqlSession = 'SELECT * FROM `Sessions`';
// $sqlSession = 'SELECT o.nom, v.nom, s.date_debut, s.date_fin FROM Ordinateurs o, Visiteurs v, Sessions s';

$querySession  = $pdo->prepare($sqlSession );


$querySession ->execute();

$resultSession  = $querySession ->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</head>

<body>
<a id="top"></a>
<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand ps-3">
        <img src="../ressources/Blue_circle_logo.svg" alt="logo" style="width:8vh;">
    </a>
    <div class="d-flex">
        <a href="reset-password.php" class="mx-5">Réinitialiser son mot de passe</a>
        <a href="../include/logout.php" class="mx-5 btn btn-primary">Se déconnecter</a>
</div>
   
  </div>
</nav>
    <div class="d-flex justify-content-center mt-5">
        <h1>Bienvenue <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></h1>
        </div>

        <div class="py-5"></div>



    <div class="row row-cols-1 row-cols-md-2 g-4 px-5">
        <h2>Liste des visiteurs :</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>
                <?php
            foreach($result as $info){
        ?>
                <tr>
                    <td><?= $info['id_visiteur'] ?></td>
                    <td><?= $info['nom'] ?></td>
                    <td><a href="../include/update.php?id=<?= $info['id_visiteur'] ?>">Modifier</a>

                    </td>

                    <td><a href="../include/delete.php?id=<?= $info['id_visiteur'] ?>">Supprimer</a></td>

                </tr>
                <?php
            }
        ?>
            </tbody>
        </table>

    </div>
    <!-- Button trigger modal -->
    <div class="ps-5 pt-3"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Ajouter un visiteur
        </button></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un visiteur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="pb-3"><label for="nom">Nom</label></div>

                        <input type="text" name="nom" id="nom">
                        <div class="modal-footer mt-5">
                            <button class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- end modal -->



    <div class="py-5 my-5"></div>

    <div class="row row-cols-1 row-cols-md-2 g-4 px-5">
        <h2>Liste des ordinateurs :</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>
                <?php
            foreach($resultComp as $infoComp){
        ?>
                <tr>
                    <td><?= $infoComp['id_ordinateur'] ?></td>
                    <td><?= $infoComp['nom'] ?></td>
                    <td><a href="../include/updateComp.php?id=<?= $infoComp['id_ordinateur'] ?>">Modifier</a>

                    </td>

                    <td><a href="../include/deleteComp.php?id=<?= $infoComp['id_ordinateur'] ?>">Supprimer</a></td>

                </tr>
                <?php
            }
        ?>
            </tbody>
        </table>

    </div>
    <!-- Button trigger modal -->
    <div class="ps-5 pt-3"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal2">
            Ajouter un ordinateur
        </button></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Ajouter un ordinateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="pb-3"><label for="nomComp">Nom</label></div>

                        <input type="text" name="nomComp" id="nomComp">
                        <div class="modal-footer mt-5">
                            <button class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- end modal -->

    <div class="py-5 my-5"></div>

    <div class="row row-cols-1 row-cols-md-2 g-4 px-5">
        <h2>Liste des sessions :</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date de debut</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">ID visiteur</th>
                    <th scope="col">ID ordinateur</th>
                    <th scope="col"></th>


                </tr>
            </thead>

            <tbody>
                <?php
        foreach($resultSession as $infoSession){
    ?>
                <tr>
                    <td><?= $infoSession['id_session'] ?></td>
                    <td><?= $infoSession['date_debut'] ?></td>
                    <td><?= $infoSession['date_fin'] ?></td>
                    <td><?= $infoSession['id_visiteur'] ?></td>
                    <td><?= $infoSession['id_ordinateur'] ?></td>
                    <td><a href="../include/deleteSession.php?id=<?= $infoSession['id_session'] ?>">Supprimer</a></td>

                    <?php
        }
    ?>
            </tbody>
        </table>

    </div>


    <!-- Button trigger modal -->
    <div class="ps-5 pt-3"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal3">
            Ajouter une session
        </button></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Ajouter une session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="pb-3"><label for="dateDebut">Date de début</label></div>
                        <input type="datetime-local" name="debutSession" id="debutSession">
                        <div class="py-3"><label for="dateFin">Date de fin</label></div>
                        <input type="datetime-local" name="finSession" id="finSession">

                        <div class="pt-5"><select name="choixOrdi" class="form-select" aria-label="Default select example"></div>
                        <option selected>Veuillez choisir un ordinateur</option>
                            <?php
            foreach($resultComp as $infoComp){
        ?>
                            <option value="<?= $infoComp['id_ordinateur'] ?>"><?= $infoComp['nom'] ?></option>

                            <?php
        }
    ?>

                        </select>

                        <div class="pt-5"><select name="choixVisiteur" class="form-select" aria-label="Default select example"></div>
                        <option selected>Veuillez choisir un visiteur</option>
                            <?php
            foreach($result as $info){
        ?>
                            <option value="<?= $info['id_visiteur'] ?>"><?= $info['nom'] ?></option>

                            <?php
        }
    ?>
                        </select>



                        <div class="modal-footer mt-5">
                            <button class="btn btn-primary" name="buttonSession">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- end modal -->
    </div>
    </div>
    <footer class="container">
    
    <div class="menu-footer d-flex justify-content-center align-items-center"  style="height:30vh;">
        <p class="text-uppercase me-5">
        <a href="#top">Haut de page</a>
        </p>
    </div>
</footer>


</body>

</html>