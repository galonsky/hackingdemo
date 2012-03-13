<?php

//includes $host, $username, $password, $dbname
include_once "db.php";

$link = mysql_connect($host, $username, $password);
mysql_select_db($dbname);

?>