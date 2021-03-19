<?php

session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header('Location: pages/welcome.php');
    exit;
}
 

require_once "../include/config.php";


$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // validation du nouveau mot de passe
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Merci de rentrer le nouveau mot de passe";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Le mot de passe doit contenir au moins 6 caractères";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Merci de bien vouloir confirmer le mot de passe";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Les mots de passes sont différents";
        }
    }
        
    // verifier si pas d'erreurs
    if(empty($new_password_err) && empty($confirm_password_err)){
        // preparation de la requête
        $sql = "UPDATE Administrateur SET password = :password WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            // paramètres attachés tout ça tout ça
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // les paramètres en question
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // exec
            if($stmt->execute()){
                // changement de mot de passe reussi, on detruit la session et on renvoie vers la page de login
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


</head>
<body>
<div class="d-flex flex-column align-items-center justify-content-center container-fluid">
        <h2>Changement de mot de passe</h2>
        <p>Merci de bien vouloir remplir ces champs pour modifier votre mot de passe</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
            <div class="form-group mb-3 <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-primary" value="Submit">Envoyer</button>
                <a class="btn btn-link" href="welcome.php">Annuler</a>
            </div>
        </form>
    </div>    
</body>
</html>