<?php
$servername = "us-cdbr-east-03.cleardb.com";
$username = "b86ba72a9788a4";
$password = "13a4dfbb";
$dbname = "heroku_99c077ce9940398";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to create table
  $sql = "INSERT INTO Administrateur VALUES ('1', 'admin@gmail.com', '$2y$10$M63xlHf/hJKb6EJnz9uMFOL6q4c.BLBMzUPpgWSf86U0WH96.HBJe');
  ";

  // use exec() because no results are returned
  $conn->exec($sql);
  echo "La liste des tables a été créé !";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>