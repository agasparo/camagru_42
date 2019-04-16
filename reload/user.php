<?php
require_once('../config/database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
?>
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