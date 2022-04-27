<?php 
$dsn = 'mysql:host=localhost; dbname=BDDGSTEST; port=3306; charset=utf8';

try {
    $pdo = new PDO($dsn, 'root' , '');
}
catch (PDOException $exception) {
    exit('Erreur de connexion � la base de donn�es');
}

?>