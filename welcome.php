<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<body>
    <div class="page-header">
        <h1>Test pipi <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Réinitialiser son mot de passe</a>
        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
    </p>
</body>
</html>