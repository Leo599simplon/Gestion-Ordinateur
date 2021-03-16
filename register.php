<?php

require_once "config.php";

// definition des variables 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validation du nom du joueur
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // preparation de la requete SQL SELECT 
        $sql = "SELECT id FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // lier les variables en paramètres à la requête
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // paramètres
            $param_username = trim($_POST["username"]);

            // execution de la requête
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // fermeture de la requête
            unset($stmt);
        }
    }

    // Validation mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validation confirmation mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Verifier si pas d'erreur avant ajout dans bdd
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // requête SQL INSERT
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // lier les variables en paramètre aux 2 requêtes
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // paramètres
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // crypter le mot de passe

            // execution de la requête
            if ($stmt->execute()) {
                // redirection à la page de login
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // fermer la déclaration
            unset($stmt);
        }
    }

    // fermer la connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page d'inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>

<body>
    <div class="d-flex flex-column align-items-center justify-content-center container-fluid">
        <h2>Inscription</h2>
        <p>Merci de bien vouloir remplir ces champs</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Nom</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group mb-3<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <div id="passwordHelpBlock" class="form-text">
                    minimum 6 caractères
                </div>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group mb-3<?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Confirmez le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary" value="Submit">Valider</button>
                <button type="reset" class="btn btn-danger" value="Reset">Suppprimer</button>
            </div>
            <p class="mt-3">Déjà un compte? <a href="login.php">Se connecter</a>.</p>
        </form>
    </div>
</body>

</html>