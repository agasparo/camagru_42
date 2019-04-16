<?php
	require_once('../config/database.php');
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
?>
<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>Camagru</title>
	<link rel="icon" type="image/png" href="../images/icon.png" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
	<div id="menu">
		<h1>Camagru</h1>
	</div>
	<div id="form_change">
		<h1>Formulaire de récuperation</h1>
		<hr>
		<img src="../images/avatar.png" class="avatar_change">
		<p id="retour"></p>
		<input type="text" name="username" placeholder="Votre nom d'utilisateur" class="form_rep" id="get_username" style="opacity: 1;">
		<button id="valid">Suivant</button>
		<a href="../index.php" id="back">retour</a>
	</div>
	<script type="text/javascript" src="../js/change_mdp.js"></script>
</body>