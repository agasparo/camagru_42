<?php

require_once('../config/database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);

$in = htmlspecialchars($in);
$name = htmlspecialchars($name);

if ($type == 1) {
	$req = $bdd->prepare('SELECT * FROM membre WHERE nom_prenom = ?');
	$req->execute(array($in));
	$count = $req->rowCount();
	$get = $req->fetch();
	if ($count > 0)
		echo $get['nom_prenom'];
	else
		echo "no";
} else if ($type == 2) {
	$req = $bdd->prepare('SELECT * FROM membre WHERE nom_prenom = ? AND mail = ?');
	$req->execute(array($name, $in));
	$count = $req->rowCount();
	$get = $req->fetch();
	if ($count > 0)
		echo $get['id'];
	else
		echo "no";
} else {
	$mdp = $in;
	$test = preg_replace('/[1234567890]/iu', "", $mdp);
	if (ctype_alnum($mdp) AND preg_match('/([0-9]+)/', $mdp) AND ctype_alpha($test)) {
		$show_mdp = $mdp;
		$mdp = sha1(md5($mdp));
		$req = $bdd->prepare('UPDATE membre SET password = ? WHERE id = ?');
		$req->execute(array($mdp, $email));
		$get_mail = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
		$get_mail->execute(array($email));
		$mail = $get_mail->fetch();
		$header="MIME-Version: 1.0\r\n";
		$header.='From:"Camagru.com"<support@Camagru.com>'."\n";
		$header.='Content-Type:text/html; charset="uft-8"'."\n";
		$header.='Content-Transfer-Encoding: 8bit';

		$message='
		<html>
		<body>
		<div align="center">
		<h2><u>Salut '.$name.' voici tes nouveaux identifiants : </u></h2>
		<ul>
		<li>Identifiant : '.$name.'</li>
		<br>
		<li>Mot de passe : '.$show_mdp.'</li>
		</ul>
		</div>
		</body>
		</html>
		';

		mail($mail['mail'], "Changement de ton mot de passe", $message, $header);
		echo "ok";
	} else {
		echo "no";
	}
}
?>