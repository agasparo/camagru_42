<?php
require_once('../config/database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

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