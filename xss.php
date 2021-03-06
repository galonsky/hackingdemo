<?php

//includes $host, $username, $password, $dbname
$envFile = @file_get_contents("/home/dotcloud/environment.json");
if ($envFile) {
    $envjson = json_decode($envFile,true);
    $port = $envjson['DOTCLOUD_DB_MYSQL_PORT'];
    $host = $envjson['DOTCLOUD_DB_MYSQL_HOST'] . ":$port";
    $username = $envjson['CPS182_DEMO_USER'];
    $password = $envjson['CPS182_DEMO_PASS'];
    $dbname = $envjson['CPS182_DEMO_DB'];
} else {
    require_once("db.php");
}

function reset_table() {
    $query = "DROP TABLE IF EXISTS `comments`;";
    mysql_query($query);
    
    create_table();
    
    $query = "INSERT INTO `comments` VALUES (null, 'alex', 'i am alex, this is my comment');";
    mysql_query($query);
    
    $query = "INSERT INTO `comments` VALUES (null, 'joe', 'i am joe, i am cool');";
    mysql_query($query);

    $query = "INSERT INTO `comments` VALUES (null, 'dean', 'i am dean, i am a noob');";
    mysql_query($query);
}

function create_table() {
     $query = "CREATE TABLE IF NOT EXISTS `comments` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(50) NOT NULL,
      `comment` varchar(1024) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    mysql_query($query);
}

function showComments() {
    $query = "SELECT * FROM comments";
    $result = mysql_query($query);

    echo "<h2>Comments:</h2>";
    while ($row = mysql_fetch_assoc($result)) {
        echo $row['username'] . " - " . $row['comment'] . "<br /><br />";
    }
}

$link = mysql_connect($host, $username, $password);
mysql_select_db($dbname);
create_table();

if(isset($_POST['name'])) {    
    reset_table();

    $query = "INSERT INTO `comments` VALUES (null, '" . $_POST['name'] . "', '" . $_POST['comment'] . "');";
    mysql_query($query);
}
?>

<html>
<head><title>Cross-site Scripting Demo</title></head>
<body>
<?php showComments(); ?>
<br /><br />
<h2>Enter a new comment:</h2>
<form id="form" action='xss.php' method='post'>
    <label for='name'>Enter your name:</label>
    <br />
    <input type='text' id='name' name='name'>
    <br /><br />
    <label for='name'>Enter your password:</label>
    <br /><i>you can just enter any random password for the demo's purposes</i>
    <br />
    <input type='text' id='password' name='password'>
    <br /><br />
    <label for='name'>Enter your comment:</label>
    <br />
    <input type='text' id='comment' name='comment'>
    <input type='submit' value='submit'>
</form>
<br />
<i>Hint: try entering the following for your comment:</i>
<pre>&lt;script type="text/javascript" src="malicious-script.js"&gt;&lt;/script&gt;</pre>
<i>After you submit this comment, try adding another regular comment and see what happens</i>
</body>
</html>
