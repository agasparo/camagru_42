<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
extract($_POST);
$req = $bdd->query("SELECT * FROM galerie ORDER BY id DESC");
$count = $req->rowCount();
if (isset($commence) AND $commence > 0)
	$co = $commence * 6;
else 
	$co = 0;
$c = 6;
if ($co != 0) {
	$c = $count - $co;
	if ($c - 6 < 6 AND $c - 6 != 6) {
		$f = $c - 6;
	} else {
		$c = 6;
	}
}

if ($count - ($co + $c) < 6 && ($co + $c) != $count) {
	$co = 0;
	$c = $count;
}
$a = 0;
while ($req_img = $req->fetch()) {
	if ($co <= $a AND $a < ($co + $c)) {
			$reqs = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
			$reqs->execute(array($req_img['id_user']));
			$info = $reqs->fetch();
		?>
		<div id="<?php echo $req_img['id'].'go_to'; ?>">
		<div class='carte_gal' id='<?= $info["id"]; ?>'>
			<h3><?= $info['nom_prenom']; ?></h3>
			<img src="<?php echo $req_img['photo']; ?>" class="img_pub">
				<p class="aime" id="<?php echo $req_img['id'].'aimes'; ?>">j'aime</p>
				<div class="comment" id="<?= $req_img['id'].'comm_re'; ?>">
					<?php
					$requete = $bdd->prepare("SELECT * FROM comm WHERE id_obj = ?");
					$requete->execute(array($req_img['id'].'comm'));
					while ($req_comm = $requete->fetch()) {
						$reqtes = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
						$reqtes->execute(array($req_comm['id_user']));
						$info = $reqtes->fetch();
						?><p class="comm_show"><strong><?= $info['nom_prenom']; ?></strong><?= " ".$req_comm['texte']; ?></p><?php
					}
					?>
				</div>
				<hr class="comm_o">
				<textarea id="<?= $req_img['id'].'comms'; ?>" name="<?= $req_img['id_user']; ?>" class="comm_write" placeholder="Ajouter un commentaire ..."></textarea>
				<p class="comm_send" id="<?= $req_img['id'].'comm'; ?>">Envoyer</p>
		</div>
	</div>
		<?php
	}
	$a++;
}
?>
<br><br><br><br>