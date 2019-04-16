<?php

require_once('database.php');
$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
session_start();

function get_ip()
{
    if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif ( isset ( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip  = $_SERVER['HTTP_CLIENT_IP'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Espace membres"');
    header('HTTP/1.0 401 Unauthorized');
} else {
    if ($_SERVER['PHP_AUTH_USER'] == 'admin' AND $_SERVER['PHP_AUTH_PW'] == 'arthur31') {
        echo "<a href='setup.php'>Initializer la bdd : </a>";
        $_SESSION['conf'] = 1;
    } else {
        $_SESSION['conf'] = 0;
        $req_ip = $bdd->prepare("SELECT * FROM banned WHERE ip = ?");
        $req_ip->execute(array(get_ip()));
        $c = $req_ip->rowCount();
        if ($c == 0) {
            $ban = $bdd->prepare("INSERT INTO banned (ip) VALUES (?)");
            $ban->execute(array(get_ip()));
        }
        echo "<html><body><a href='../index.php'>Initializer la base de donnée</a></body></html>\n";
    }
}
?>