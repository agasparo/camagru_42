<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
extract($_POST);

if (isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
	
	if ($id == 1) {
		$file = 'images/' . uniqid() . '.png';
		$uri = str_replace("data:image/png;base64,", "", $photo);
		file_put_contents($file, base64_decode($uri), FILE_USE_INCLUDE_PATH);
		$insert = $bdd->prepare("INSERT INTO img (photo, id_user) VALUES (?, ?)");
		$insert->execute(array($file, $_SESSION['id']));
	} else {
	    if (!file_exists('tmp'))
	        mkdir('tmp');
		$file = 'tmp/' . uniqid() . '.png';
		$uri = str_replace("data:image/png;base64,", "", $ar_p);
		file_put_contents($file, base64_decode($uri));
		$photo = str_replace("http://localhost:8081/camagru/", "", $photo);
		$file_to_recup = explode(" ", $photo);
		unset($file_to_recup[0]);
		$i = 1;
		while (isset($file_to_recup[$i]))
			$i++;
		$i--;
		while (isset($file_to_recup[$i])) {
			$j = 0;
			$c = 0;
			while (isset($file_fin[$j])) {
				$a = explode(':', $file_to_recup[$i]);
				$b = explode(':', $file_fin[$j]);
				if ($a[0] == $b[0])
					$c++;
				$j++;
			}
			if ($c == 0)
				$file_fin[$j] = $file_to_recup[$i];
			$i--;
		}
		$i = 0;
		while (isset($file_fin[$i]))
			$i++;
		$i--;
		$a = $i;
		print_r($file_fin);
		while (isset($file_fin[$i])) {
			$inf = explode(':', $file_fin[$i]);
			if ($inf[0] != "k") {
				$source = imagecreatefrompng($inf[0]); // image a chercher
				$largeur_source = $inf[1] * (300 / $canvas_w); // les nouvelles dimensions x
				$hauteur_source = $inf[2] * (150 / $canvas_h); // les nouvelles dimensions y
				$size = getimagesize($inf[0]);
				$new_img = imagecreate($largeur_source, $hauteur_source); // la nouvelle image a redimensionner
				$transparence = imagecolorallocate($new_img, 0, 255, 0); // couleur pour la transparence
				imagecolortransparent($new_img, $transparence); // la transparence
				if ($a == $i)
					$destination = imagecreatefrompng($file); // La photo est la destination
				else
					$destination = imagecreatefrompng("photo_final.png"); // La photo est la destination
				imagecopyresampled($new_img, $source, 0, 0, 0, 0, $largeur_source, $hauteur_source, $size[0], $size[1]); // le nouvelle image redimensionne
				// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
				$largeur_destination = imagesy($destination);
				$hauteur_destination = imagesx($destination);
				// on calcule les coordonnées où on doit placer l'image sur la photo
				$destination_x = $inf[4] * ($hauteur_destination / $canvas_w);
				$destination_y = $inf[3] * ($largeur_destination / $canvas_h);
				// On met (source) dans l'image de destination (la photo)
				imagecopymerge($destination, $new_img, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
				// On affiche l'image de destination qui a été fusionnée avec le logo
				imagepng($destination, "photo_final.png");
			} else {
				if ($a == $i)
					$destination = imagecreatefrompng($file); // La photo est la destination
				else
					$destination = imagecreatefrompng("photo_final.png"); // La photo est la destination
				imagepng($destination, "photo_final.png");
			}
			$i--;
		}
		$chemin = 'galerie/'.$_SESSION['id'].'.'.uniqid().'.png';
		$insert = $bdd->prepare("INSERT INTO galerie (photo, id_user) VALUES (?, ?)");
		$insert->execute(array($chemin, $_SESSION['id']));
		imagepng($destination, $chemin);
		unlink($file);
	}
}