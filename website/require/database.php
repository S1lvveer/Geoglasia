<?php

// Usage: require_once("require/database.php");
// Require this any time you want access to the database! [you can just use the same $db in every file that way]

$host = "localhost";
$user = "root";
$password = "";
$db_name = "project_pai";

$db = new mysqli($host, $user, $password, $db_name);
if ($db->connect_errno) {
    echo "<div class='db-error-alert'> ERROR: Not connected to database. </div>";
}

?>