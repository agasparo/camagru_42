<?php

require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

extract($_POST);

$mdp = htmlspecialchars($form_inscription_mdp);
$pseudo = htmlspecialchars($form_inscription_pseudo);
$mail = htmlspecialchars($form_inscription_mail);
$mdp2 = htmlspecialchars($form_inscription_mdp2);


if ((isset($mdp) AND !empty($mdp)) AND (isset($mdp2) AND !empty($mdp2)) AND isset($pseudo) AND !empty($pseudo) AND isset($mail) AND !empty($mail)) {
	$test = preg_replace('/[1234567890]/iu', "", $mdp);
	if (ctype_alnum($mdp) AND preg_match('/([0-9]+)/', $mdp) AND ctype_alpha($test)) {
	    $show_mdp = $mdp;
		$mdp = sha1(md5($mdp));
		$mdp2 = sha1(md5($mdp2));
		if ($mdp == $mdp2) {
			if (strlen($pseudo) > 5) {
				if (ctype_alnum($pseudo)) {
					if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
						$req_pseudo = $bdd->prepare("SELECT * FROM membre WHERE nom_prenom = ?");
						$req_pseudo->execute(array($pseudo));
						if (($req_pseudo = $req_pseudo->rowCount()) < 1) {
							$insert_tab = $bdd->prepare("INSERT INTO membre (nom_prenom, mail, password, verif) VALUES (?, ?, ?, ?)");
							$insert_tab->execute(array($pseudo, $mail, $mdp, 0));
							$set_id = $pseudo;
                            $header="MIME-Version: 1.0\r\n";
                            $header.='From:"Camagru.com"<support@Camagru.com>'."\n";
                            $header.='Content-Type:text/html; charset="uft-8"'."\n";
                            $header.='Content-Transfer-Encoding: 8bit';
                            $message='
                            <html>
                            <body>
                            <div align="center">
                            <h2><u>Salut '.$pseudo.' voici tes identifiants : </u></h2>
                            <ul>
                            <li>Identifiant : '.$pseudo.'</li>
                            <br>
                            <li>Mot de passe : '.$show_mdp.'</li>
                            </ul>
                            <a href="http://localhost:8081/camagru/verif.php?confirm='.$set_id.'">Confirmer son mail</a>
                            </div>
                            </body>
                            </html>
                            ';
                            
                            mail($mail, "Verification de ton mail pour l'inscription", $message, $header);
							echo "bravo inscription reussi";
						} else {
							echo "Votre pseudo exites deja";
						}
					} else {
						echo "mauvais mail";
					}
				} else {
					echo "Votre pseudo doit contenir que des chiffres et des lettres";
				}
			} else {
				echo "Votre pseudo dois faire un minimun 5 caractères";
			}
		} else {
			echo "les mot de passes ne concordent pas";
		}
	} else {
		echo "Votre mot de passe doit contenir chiffres et lettres et pas de 0";
	}
} else {
	echo "Tous les champs doivent etre remplis ";
}
