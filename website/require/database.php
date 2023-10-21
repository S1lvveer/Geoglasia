<?php

// Usage: require_once("require/database.php");
// Require this any time you want access to the database! [you can just use the same $db in every file that way]

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "project_pai";

$db = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($db->connect_errno) {
    echo "<div class='db-error-alert'> ERROR: Not connected to database. </div>";
}

function getUser() {
    global $db;

    $user = null;
    if ( isset($_COOKIE['login_token']) ) {
        $token = $_COOKIE['login_token'];

        // Find user id
        $sql = "SELECT * FROM sessions WHERE token = '$token'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $user_ses = $result->fetch_assoc();
            $userid = $user_ses['user_id'];

            // Find user and save it to the $user variable
            $sql = "SELECT * FROM users WHERE user_id = $userid";
            $result = $db->query($sql);

            $user = $result->fetch_assoc();
        }
    }

    return $user;
}

?>