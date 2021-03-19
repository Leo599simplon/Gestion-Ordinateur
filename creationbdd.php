<?php
$servername = "13a4dfbb@us-cdbr-east-03.cleardb.com";
$username = "b86ba72a9788a4";
$password = "13a4dfbb";
$dbname = "heroku_99c077ce9940398";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // sql to create table
  $sql = "CREATE TABLE Visiteurs (
    id_visiteur INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_visiteur)
);


CREATE TABLE Administrateur (
    id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE Ordinateurs (
    id_ordinateur INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_ordinateur)
);


CREATE TABLE Sessions (
    id_session INT AUTO_INCREMENT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    id_ordinateur INT NOT NULL,
    id_visiteur INT NOT NULL,
    PRIMARY KEY (id_session)
);


ALTER TABLE Sessions ADD CONSTRAINT visiteurs_sessions_fk
FOREIGN KEY (id_visiteur)
REFERENCES Visiteurs (id_visiteur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Sessions ADD CONSTRAINT ordinateurs_sessions_fk
FOREIGN KEY (id_ordinateur)
REFERENCES Ordinateurs (id_ordinateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
  ";

  // use exec() because no results are returned
  $conn->exec($sql);
  echo "La liste des tables a été créé !";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?> 