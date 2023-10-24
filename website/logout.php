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

// While we're at it, log out all expired sessions
$now = time();

$stmt = $db->stmt_init();
$stmt->prepare("DELETE FROM sessions WHERE expires_at < ?");
$stmt->bind_param("i", $now);
$stmt->execute();
$stmt->close();


// Destroy the cookie.
setcookie("login_token", "", time() - 3600, "/");
unset($_COOKIE['login_token']);

session_destroy();
header('Location: login.php');
?>