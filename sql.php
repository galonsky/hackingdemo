<?php

//includes $host, $username, $password, $dbname
require_once("db.php");

function reset_table() {
    $query = "DROP TABLE IF EXISTS `users`;";
    mysql_query($query);
    
    $query = "CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(50) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    
    mysql_query($query);
}

$link = mysql_connect($host, $username, $password);
mysql_select_db($dbname);
reset_table();

?>