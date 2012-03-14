<html>
<head><title>Cross-site Scripting Demo</title></head>
<body>
<?php

//includes $host, $username, $password, $dbname
require_once("db.php");

function reset_table() {
    $query = "DROP TABLE IF EXISTS `comments`;";
    mysql_query($query);
    
    $query = "CREATE TABLE IF NOT EXISTS `comments` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(50) NOT NULL,
      `comment` varchar(1024) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    mysql_query($query);
    
    $query = "INSERT INTO `comments` VALUES (null, 'alex', 'i am alex, this is my comment');";
    mysql_query($query);
    
    $query = "INSERT INTO `comments` VALUES (null, 'joe', 'i am joe, i am cool');";
    mysql_query($query);

    $query = "INSERT INTO `comments` VALUES (null, 'dean', 'i am dean, i am a noob');";
    mysql_query($query);
}

function showComments() {
    $query = "SELECT * FROM comments";
    $result = mysql_query($query);

    echo "<h2>Comments:</h2>";
    while ($row = mysql_fetch_assoc($result)) {
        echo $row['name'] . " - " . $row['comment'] . "<br />";
    }
}

if(isset($_GET['name'])) {
    $link = mysql_connect($host, $username, $password);
    mysql_select_db($dbname);
    
    reset_table();

    $query = "INSERT INTO `comments` VALUES (null, '" . $_GET['name'] . "', '" . $_GET['comment'] . "');";
    mysql_query($query);
}

showComments();

?>

<br /><br />
<h2>Enter a new comment:</h2>
<form action='xss.php' method='get'>
    <label for='name'>Enter your name:</label>
    <br />
    <input type='text' id='name' name='name'>
    <br /><br />
    <label for='name'>Enter your password:</label>&nbsp;&nbsp;<i>you can just enter any random password for the demo's purposes</i>
    <br />
    <input type='text' id='password' name='password'>
    <br /><br />
    <label for='name'>Enter your comment:</label>
    <br />
    <input type='text' id='comment' name='comment'>
    <input type='submit' value='submit'>
</form> 
</body>
</html>
