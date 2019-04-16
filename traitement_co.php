<?php

require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

extract($_POST);

$mdpconnect = sha1(md5($form_connection_mdp));
$pseudo_connect = htmlspecialchars($form_connection_pseudo);

if (isset($pseudo_connect) AND !empty($pseudo_connect) AND isset($mdpconnect) AND !empty($mdpconnect)) {
	$requser = $bdd->prepare("SELECT * FROM membre WHERE nom_prenom = ? AND password = ? AND verif = ?");
	$requser->execute(array($pseudo_connect, $mdpconnect, 1));
	$userexist = $requser->rowCount();
	if ($userexist == 1) {
		$userinfo = $requser->fetch();
		$_SESSION['id'] = $userinfo['id'];
		echo "connection ...";
	} else {
		echo "Mauvais pseudo ou mauvais mot de passe !";
	}
} else {
	echo "Tous les champs doivent etre remplis ";
}
?>