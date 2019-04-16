<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
extract($_POST);

if ($id == 1) {
    $req_mail = $bdd->prepare('SELECT * FROM mail WHERE id_user = ?');
    $req_mail->execute(array($_SESSION['id']));
    $ct = $req_mail->rowCount();
    if ($ct == 0) {
        $insert_mail = $bdd->prepare('INSERT INTO mail (id_user) VALUES(?)');
        $insert_mail->execute(array($_SESSION['id']));
    }
} else {
    $req_mail = $bdd->prepare('SELECT * FROM mail WHERE id_user = ?');
    $req_mail->execute(array($_SESSION['id']));
    $ct = $req_mail->rowCount();
    if ($ct > 0) {
        $delete_mail = $bdd->prepare('DELETE FROM mail WHERE id_user = ?');
        $delete_mail->execute(array($_SESSION['id']));
    }
}

?>