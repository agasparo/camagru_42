<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);
session_start();

$link_img = explode('camagru/', $src);

$get_img = $bdd->prepare("DELETE FROM galerie WHERE photo = ?");
$get_img->execute(array($link_img[1]));

?>