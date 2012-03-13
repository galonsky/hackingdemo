<html>
<head><title>SQL Injection Demo</title></head>
<body>
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
    
    $query = "INSERT INTO `users` VALUES (null, 'alex');";
    mysql_query($query);
}

if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $link = mysql_connect($host, $username, $password);
    mysql_select_db($dbname);
    reset_table();
    
    $query = "SELECT * FROM users WHERE username = '" . $name . "';";
    $result = mysql_query($query);
    $num = mysql_num_rows($result);
    if($num > 0) {
        echo "<p>Authenticated sucessfully.</p>";
    } else {
        echo "<p>Incorrect credentials.</p>";
    }
}


?>
<form action='sql.php' method='get'>
    <label for='name'>Enter your name to enter the secure area:</label>
    <input type='text' id='name' name='name'>
    <input type='submit' value='submit'>
</form>
<p>Hint: here's the query that's being run:</p>
<pre>$query = "SELECT * FROM users WHERE username = '" . $name . "';";</pre>
</body>
</html>