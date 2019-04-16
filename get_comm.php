<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);
session_start();

$requete = $bdd->prepare("SELECT * FROM comm WHERE id_obj = ?");
$requete->execute(array($id));
while ($req_comm = $requete->fetch()) {
	$reqtes = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
	$reqtes->execute(array($req_comm['id_user']));
	$info = $reqtes->fetch();
	?><p class="comm_show"><strong><?= $info['nom_prenom']; ?></strong><?= " ".$req_comm['texte']; ?></p><?php
}
?>