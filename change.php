<?php
require_once('config/database.php');

$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();
extract($_POST);


if (isset($mail) && !empty($mail)) {
    $req_mail = $bdd->prepare("UPDATE membre SET mail = ? WHERE id = ?");
    $req_mail->execute(array($mail, $_SESSION['id']));
}

if (isset($pseudo) && !empty($pseudo)) {
    $check_mail = $bdd->prepare("SELECT * FROM membre WHERE nom_prenom = ?");
    $check_mail->execute(array($pseudo));
    $exist = $check_mail->rowCount();
    if ($exist == 0) {
        $req_pseudo = $bdd->prepare("UPDATE membre SET nom_prenom = ? WHERE id = ?");
        $req_pseudo->execute(array($pseudo, $_SESSION['id']));
    } else {
        echo "Ce pseudo est deja utilise";
    }
}

if (isset($mdp) && !empty($mdp) && isset($mdp1) && !empty($mdp1)) {
    $mdp = sha1($mdp);
    $req_mail = $bdd->prepare("UPDATE membre SET mdp = ? WHERE id = ?");
    $req_mail->execute(array($mdp, $_SESSION['id']));
}
?>