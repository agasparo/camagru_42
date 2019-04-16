<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
?>
<html>
	<header>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</header>
	<body>
	<?php
		$req = $bdd->prepare("SELECT * FROM img WHERE id_user = ? ORDER BY id DESC");
		$req->execute(array($_SESSION['id']));
		$i = 1;
		while ($requ = $req->fetch()) {
			?>
			<img src="<?php echo $requ['photo']; ?>" class="img_fond" onclick="do_fd(this.id)" id="<?php echo 'img_fond'.$i; ?>">
			<?php
			$i++;
		}
		?>
	</body>
</html>