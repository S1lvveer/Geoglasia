<?php
session_start();
require_once("require/database.php");

// Remove the session from the database.
if ( isset($_COOKIE['login_token'])) {
    $token = $_COOKIE['login_token'];

    // Delete the session from the "sessions" table
    $sql = "DELETE FROM sessions WHERE token = '$token'";
    $result = $db->query($sql);
}

// Destroy the cookie.
setcookie("login_token", "", time() - 3600, "/");
unset($_COOKIE['login_token']);

session_destroy();
header('Location: login.php');
?>