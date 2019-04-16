<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);
session_start();


if (isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
	$message = htmlspecialchars($msg);
	if (strlen($message) > 0) {
        $message = str_replace(":)", "&#128512;", $message);
        $message = str_replace("^^", "&#128513;", $message);
        $message = str_replace(":')", "&#128514;", $message);
        $message = str_replace(";)", "&#128527;", $message);
        $message = str_replace("(-_-)", "&#128542;", $message);
        $message = str_replace("&lt;3", "&hearts;", $message);
        $message = str_replace("8)", "&#129299;", $message);
        $message = str_replace(":p", "&#128539;", $message);
        $message = str_replace(";p", "&#128540;", $message);
        $message = str_replace(":(", "&#128577;", $message);
        $message = str_replace(":o", "&#128559;", $message);
		$req = $bdd->prepare("INSERT INTO comm (id_user, texte, id_obj, id_pers) VALUES (?, ?, ?, ?)");
		$req->execute(array($_SESSION['id'], $message, $id, $id_perso));
		
    	$is_ok = $bdd->prepare('SELECT * FROM mail WHERE id_user = ?');
    	$is_ok->execute(array($id_perso));
    	$count = $is_ok->rowCount();
		if ($count == 0) {

		    $get_user = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
    	    $get_user->execute(array($id_perso));
    	    $get_id_user = $get_user->fetch();
    		
    		$get_mail1 = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
    		$get_mail1->execute(array($_SESSION['id']));
    		$get_mail12 = $get_mail1->fetch();
    		
    		
    		$header="MIME-Version: 1.0\r\n";
            $header.='From:"Camagru.com"<support@Camagru.com>'."\n";
            $header.='Content-Type:text/html; charset="uft-8"'."\n";
            $header.='Content-Transfer-Encoding: 8bit';
            
            $message='
            <html>
            <body>
            <div align="center">
            <h2><u>Salut '.$get_id_user["nom_prenom"].' '.$get_mail12["nom_prenom"].' as laisse un commentaire sur ta photo</u></h2>
            '.$get_mail12["nom_prenom"].' : '.$message.'
            </div>
            </body>
            </html>
            ';
            mail($get_id_user['mail'], "Commentaire recus", $message, $header);
            echo "good";
		}
	}
}