<?php
session_name('admin_session');

session_start();

if (isset($_SESSION["user_id"])) {
	session_destroy();
	header("location: login_admin.php");
}

header("location: login_admin.php");
?>