<?php
abstract class Connexion {
protected $pdo;
function __construct()
{
$this->pdo =new PDO('mysql:host=localhost;dbname=club','root','');
}
function __destruct()
{
$this->pdo=null;
}

////il vous ouvre database

}
?>