
<?php

$server   = "localhost";
$username = "root";
$password = "";
$database = "medisys";


$mysqli = new mysqli($server, $username, $password, $database);
//mysqli_set_charset($mysqli,'utf8');

if ($mysqli->connect_error) {
    die('error'.$mysqli->connect_error);
}
?>