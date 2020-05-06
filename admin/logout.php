<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';
	unset($_SESSION['User']);
	header('Location: login.php');

?>