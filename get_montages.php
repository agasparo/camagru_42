<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
extract($_POST);
session_start();


$get_montages = $bdd->prepare('SELECT * FROM galerie WHERE id_user = ? ORDER BY id DESC');
$get_montages->execute(array($_SESSION['id']));

echo "<h1 style='text-align: center; font-size: 3vh;'>Liste de tes montages</h1><p style='cursor: pointer; width: 5%; height: 10%; position: absolute; top: 2%; left : 2%;font-size: 1.8vh;' id='close_suppr'>&#10060;</p><hr>";
while ($montages = $get_montages->fetch()) {
    ?><div class='img_suppr'>
        <img src='<?= $montages['photo']; ?>' style='width: 90%; height: 70%; position: relative; left: 5%; margin-top: 5%;'/>
        <p style = 'width: 100%; text-align: center; color : #fa7e1e; position: relative;font-size: 1.8vh;' >Clicker pour supprimer</p>
    </div><?php
}
?>