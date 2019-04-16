<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

extract($_GET);

$verif_ok = $bdd->prepare("UPDATE membre SET verif = ? WHERE nom_prenom = ?");
$verif_ok->execute(array(1, $confirm));
header("Location:index.php");
?>