<?php


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project_sdf');


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}



/*
define('DB_SERVER', '185.27.134.10');
define('DB_USERNAME', 'epiz_33184146');
define('DB_PASSWORD', 'BX3Hy6zlCZG');
define('DB_NAME', 'epiz_33184146_project_sdf');


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
*/


