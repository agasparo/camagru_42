<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);
session_start();

$id = str_replace('aimes', '', $id);

if ($type == 1) {
	$req = $bdd->prepare("SELECT * FROM aime WHERE id_user = ?");
	$req->execute(array($id));
	$c = $req->rowCount();
	if ($c > 1)
		echo $c." j'aimes";
	else
		echo $c." j'aime";
} else {
	if (isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
		$req = $bdd->prepare("SELECT * FROM aime WHERE id_aim = ? AND id_user = ?");
		$req->execute(array($_SESSION['id'], $id));
		$c = $req->rowCount();
		if ($c == 0) {
			$req = $bdd->prepare("INSERT INTO aime (id_user, id_aim) VALUES (?, ?)");
			$req->execute(array($id, $_SESSION['id']));
		} else {
			$req = $bdd->prepare("DELETE FROM aime WHERE id_user = ? AND id_aim = ?");
			print_r($req);
			$req->execute(array($id, $_SESSION['id']));
		}
	}
}
?>