<?php

require_once "config.php";

// definition des variables 
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validation du nom du joueur
    if (empty(trim($_POST["email"]))) {
        $email_err = "Merci de bien rentrer votre email.";
    } else {
        // preparation de la requete SQL SELECT 
        $sql = "SELECT id FROM Administrateur WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // lier les variables en paramètres à la requête
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // paramètres
            $param_email = trim($_POST["email"]);

            // execution de la requête
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "email déjà utilisé";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "une erreur est survenue";
            }

            // fermeture de la requête
            unset($stmt);
        }
    }

    // Validation mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Merci de rentrer votre mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Votre mot de passe doit contenir au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validation confirmation mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Merci de confirmer votre mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne correspondent pas";
        }
    }

    // Verifier si pas d'erreur avant ajout dans bdd
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // requête SQL INSERT
        $sql = "INSERT INTO Administrateur (email, password) VALUES (:email, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // lier les variables en paramètre aux 2 requêtes
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // paramètres
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // crypter le mot de passe

            // execution de la requête
            if ($stmt->execute()) {
                // redirection à la page de login
                header("location: login.php");
            } else {
                echo "erreur";
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
            <div class="form-group mb-3 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Nom</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
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