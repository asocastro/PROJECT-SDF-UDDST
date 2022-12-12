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
define('DB_SERVER', 'sql.freedb.tech');
define('DB_USERNAME', 'freedb_testt');
define('DB_PASSWORD', 'GX4x$VCbVhx9#Bt');
define('DB_NAME', 'freedb_project_sdf');


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
*/


