<?php
require_once('config/database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

function get_ip()
{
    if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif ( isset ( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip  = $_SERVER['HTTP_CLIENT_IP'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$req_ip = $bdd->prepare("SELECT * FROM banned WHERE ip = ?");
$req_ip->execute(array(get_ip()));
$c = $req_ip->rowCount();
if ($c >= 1) {
	echo "ah ... tu n'etais pas admin ...";
	exit(0);
}

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Camagru</title>
	<link rel="icon" type="image/png" href="images/icon.png" />
</head>
<body>
	<div id="us"></div>
	<div id="menu">
		<h1>Camagru</h1>
	    <img src="images/menu.png" class="img_header" id="btn-mid">
	</div>
	<div id="go_pro">
	    <div id='mid_pro'>
		<?php
		if (isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
			$req = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
			$req->execute(array($_SESSION['id']));
			$userinfo = $req->fetch();
			echo 'Bienvenue sur ton profil '.$userinfo['nom_prenom'];
			?>
		</div>
			<br>
			<p class="link">&#9755; Quelques liens utiles : </p>
				<a href="profil.php" class='links'>&#9679; Aller dans mon studio photo</a><br>
				<a href="#" class='links' id='montages'>&#9679; Supprimer des montages</a><br>
				<a href="#" class='links' id='pref'>&#9679; Mes preferences (mail : oui)</a><br>
				<a href="deco.php" class='links'>&#9679; Se deconnecter</a><br><br>
				<p id='result_change'></p>
				<form class="form_change_inf">
					<input type="text" name="form_change_pseudo" id="form_change_pseudo" placeholder="Pseudo" class="all_forms"><br>
					<input type="email" name="form_change_mail" id="form_change_mail" autocomplete="email" placeholder="Nouveau mail" class="all_forms"><br>
					<input type="password" name="form_change_mdp" id="form_change_mdp" autocomplete="new-password" placeholder="Mot de passe" class="all_forms"><br>
					<input type="password" name="form_change_mdp2" id="form_change_mdp2" autocomplete="new-password" placeholder="Repeter votre mot de passe" class="all_forms"><br>
					<input type="submit" name="form_changes" id="form_changes" value="Modifier" class="btn-btn-vals">
				</form>
			<?php
		} else {
			?>
			<p class="co">Inscris-toi</p>
			<p id="ins_f"></p>
			<form class="form-ins">
				<input type="text" name="form_inscription_pseudo" id="form_inscription_pseudo" placeholder="Pseudo" class="all_form">
				<input type="email" name="form_inscription_mail" id="form_inscription_mail" autocomplete="email" placeholder="Mail" class="all_form">
				<input type="password" name="form_inscription_mdp" id="form_inscription_mdp" autocomplete="new-password" placeholder="Mot de passe" class="all_form">
				<input type="password" name="form_inscription_mdp2" id="form_inscription_mdp2" autocomplete="new-password" placeholder="Repeter votre mot de passe" class="all_form">
				<input type="submit" name="form_inscription" id="form_inscription" value="S'inscrire" class="btn-btn-val">
			</form>
			<p class="co-2">Ou</p>
			<p class="co-1">Connecte-toi</p>
			<a href="reload/res_mdp.php" class="mdp_res">Mot de passe oublié ?</a>
			<p id="co_f"></p>
			<form class="form-co">
				<input type="text" name="form_connection_pseudo" id="form_connection_pseudo" placeholder="Pseudo" autocomplete="username" class="all_form">
				<input type="password" name="form_connection_mdp" id="form_connection_mdp" autocomplete="new-password" placeholder="Mot de passe" class="all_form">
				<input type="submit" name="form_connection" id="form_connection" value="Se connecter" class="btn-btn-val">
			</form>
			<?php
		}
		?>
	</div>
	</div>
	<div id="galerie"></div>
	<div id="pagination">
		<h4>Pagination</h4>
	    <div id="enter_page">
		<?php
		$req = $bdd->query("SELECT * FROM galerie ORDER BY id DESC");
		$count = $req->rowCount();
		$get = $req->fetch();
		$tab = [];
		$set = [];
		$i = 0;
		$last = $get['id'];
		while ($count > 0 AND floor($count / 6) > 0) {
			$req_img1 = $bdd->prepare("SELECT * FROM galerie WHERE id = ?");
			$req_img1->execute(array($last));
			$img_to_show1 = $req_img1->fetch();
			$tab[$i] = $img_to_show1['id'];
			$set[$i] = floor($count / 6);
			$i++;
			$count = $count - 6;
			$last = $count;
		}
		if ($count > 0 && empty($tab)) {
			$i = 0;
			$req_img = $bdd->prepare("SELECT * FROM galerie WHERE id = ?");
			$req_img->execute(array($last));
			$img_to_show = $req_img->fetch();
			$tab[$i] = $img_to_show['id'];
			$set[$i] = 1;
		}
		krsort($set);
		$set = array_values($set);
		$i = 0;
		while (isset($tab[$i + 1])) {
			$id_prem = $tab[$i];
			$id_deu = $tab[$i + 1] + 1;
			$a = $id_prem;
			?><div id="<?= $set[$i].'pagination'; ?>" class="pagiation_repe"><?php
			while ($a >= $id_deu) {
				$req_img = $bdd->prepare("SELECT * FROM galerie WHERE id = ?");
				$req_img->execute(array($a));
				$get_img = $req_img->fetch();
				if (!empty($get_img['photo'])) {
					?>
						<img src="<?= $get_img['photo']; ?>" class='img_page' id="<?= $get_img['id']; ?>">
					<?php
				}
				$a--;
			}
			?></div><br><?php
			$i++;
		}
		if (isset($tab[$i])) {
		$id_prem = $tab[$i];
		$id_deu = 1;
		$a = $id_prem;
		?><div id="<?= $set[$i].'pagination'; ?>" class="pagiation_repe"><?php
		while ($a >= $id_deu) {
			$req_img = $bdd->prepare("SELECT * FROM galerie WHERE id = ?");
			$req_img->execute(array($a));
			$get_img = $req_img->fetch();
			if (!empty($get_img['photo'])) {
				?>
				<img src="<?= $get_img['photo']; ?>" class='img_page' id="<?= $get_img['id']; ?>">
				<?php
			}
			$a--;
		}
		?>
		</div>
	<?php } ?>
		</div>
		<div id="link_page">
			<?php
			foreach ($set as $key => $value) {
				?><a href="#" class='page' id="<?= $value.'page'; ?>"><?= $value; ?></a>&nbsp;<?php
			}
			?>
		</div>
	</div>
	<div id="classement_aime">
		<h4>Classement des photos les plus aimées</h4>
		<div id="tabe_in_1">
			<?php
			$tab = [];
			$id = [];
			$i = 0;
			$req = $bdd->query('SELECT * FROM galerie');
			while ($user = $req->fetch()) {
				$get_nb = $bdd->prepare('SELECT * FROM aime WHERE id_user = ?');
				$get_nb->execute(array($user['id']));
				$nb = $get_nb->rowCount();
				$tab[$i] = $nb;
				$id[$i] = $user['id_user'];
				$i++;
			}
			arsort($tab);
			$i = 0;
			?>
			<table>
				<tr>
					<td>n°</td>
					<td>Nombre de j'aime</td>
					<td>Postée par : </td>
				</tr>
				<?php
				foreach ($tab as $key => $value) {
					$get_posteur = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
					$get_posteur->execute(array($id[$value]));
					$posteur = $get_posteur->fetch();
					?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $value; ?></td>
						<td>
							<?php
							if (empty($posteur['nom_prenom']))
								echo "utilisateur supprimé";
							else
								echo $posteur['nom_prenom'];
							?>
						</td>
					</tr>
					<?php
					$i++;
				}
				?>
			</table>
		</div>
	</div>
	<div id="classement_user">
		<h4>Liste des membres</h4>
		<div id="tabe_in">
			<table>
				<tr>
					<td>n°</td>
					<td>Nom d'utilisateur</td>
				</tr>
				<?php
					$i = 0;
					$req = $bdd->query('SELECT * FROM membre');
					while ($user = $req->fetch()) {
						?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $user['nom_prenom']; ?></td>
						</tr>
						<?php
						$i++;
					}
				?>
			</table>
		</div>
	</div>
</body>
<script type="text/javascript" src="js/page.js"></script>
<script type="text/javascript" src="js/profil.js"></script>
<script type="text/javascript" src="js/change.js"></script>
<script type="text/javascript">
	setInterval(function(){
		var inf = new Array();
		post_page("reload/aim.php", inf, function(data) {
			document.getElementById('tabe_in_1').innerHTML = "";
			document.getElementById('tabe_in_1').innerHTML = data;
		});
		var inf = new Array();
		post_page("reload/user.php", inf, function(data) {
			document.getElementById('tabe_in').innerHTML = "";
			document.getElementById('tabe_in').innerHTML = data;
		});
	}, 3000);

	function post_page(url, infos, callback) {
		var http_req = new XMLHttpRequest();

		http_req.onreadystatechange = function () {
			if (http_req.readyState === 4) {
				callback(http_req.responseText);
			}
		}
		http_req.open('POST', url, true);
		http_req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		var i = 0;
		var variables = "";
		while (i < infos.length) {
			variables = variables+infos[i];
			i++;
		}
		http_req.send(variables);
	}
</script>
</html>