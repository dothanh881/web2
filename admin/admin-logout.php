<?php
session_name('admin_session');

session_start();

if (isset($_SESSION["user_id"])) {
	session_destroy();
	header("location: login.php");
}

header("location: login.php");
?>