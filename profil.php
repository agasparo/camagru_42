<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
if (isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Studio de creation</title>
		<link rel="icon" type="image/png" href="images/icon.png" />
	</head>
	<body>
	    <h1 class='title_profil'>Bienvenue sur ton studio de creation</h1><a href="deco.php" class='links'> (Se deconnecter)</a>
		<video id="video" width="840" height="480" autoplay hidden="hidden"></video>
		<button id="snap" class='btn-btn-pro'>Prendre une photo</button>
		<canvas id="canvas" width="840" height="480" hidden="hidden"></canvas>
		<canvas id="draw" class="droppable"></canvas>
		<div id="rescep">
			<video autoplay id="fond_v" class="img_fond" onclick="do_fd(this.id)"></video>
			<div id="img_show"></div>
		</div>
		<div id="img_sup" class="droppable">
		</div>
		<button class='btn-btn-pro' id="pub">Publier ma photo</button>
		<button class='btn-btn-pro' id="img_insert_btn">Ajouter une photo</button>
		<input type='file' id='img_insert' hidden='hidden'/>
		<button class='btn-btn-pro' id="reset_montage" onclick="location.reload();">Reset</button>
		<button class='btn-btn-pro' id="go_home" onclick="window.location='index.php';">Acceuil</button>
	</body>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/canvas.js"></script>
	<script type="text/javascript" src="js/dad.js"></script>
	<script type="text/javascript" src="js/image.js"></script>
	</html>
	<?php
} else {
	header("Location:index.php");
}
