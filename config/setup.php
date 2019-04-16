<?php

require_once('database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

if (isset($_SESSION['conf']) AND $_SESSION['conf'] == 1) {

    function executeQueryFile($filesql, $bdd) {
        $query = file_get_contents($filesql);
        $array = explode(";\n", $query);
        $b = true;
        for ($i=0; $i < count($array) ; $i++) {
            $str = $array[$i];
            if ($str != '') {
                 $str .= ';';
                 $b = $bdd->exec($str);  
            }  
        }
        return $b;
    }
    if(executeQueryFile("data.sql", $bdd) == 0) {
        echo "data exec : success";
    }
} else {
    header("Location:../index.php");
}
?>