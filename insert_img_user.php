<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

extract($_POST);

$output_file = 'images/'.uniqid().'.png';
$file = fopen($output_file, "wb");
$data = explode(',', $base64);
fwrite($file, base64_decode($data[1]));
fclose($file);
$dimensions = getimagesize($output_file);
echo $type;
if ($type == 'png')
	$imageChoisis = imagecreatefrompng($output_file);
else
	$imageChoisis = imagecreatefromjpeg($output_file);
$ImageFinal = imagecreatetruecolor(880, 600);
imagecopyresampled($ImageFinal, $imageChoisis, 0, 0, 0, 0, 880, 600, $dimensions[0], $dimensions[1]);
imagedestroy($imageChoisis);
imagejpeg($ImageFinal, $output_file, 100);

$insert_img = $bdd->prepare('INSERT INTO img(photo, id_user) VALUES(?, ?)');
$insert_img->execute(array($output_file, $_SESSION['id']));
?>