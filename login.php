<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
// include 'views/head.php';


if (isset($_POST['login'])) {
	$voter = sanitize($_POST['voters_id']);
	$password = sanitize($_POST['pwd']);
	$errors = array();

	// form validation
	if (empty($_POST['voters_id']) && empty($_POST['pwd'])) {
		$errors[] = 'You must provide Voter\'s ID and Password.';
	} else {
		if (empty($_POST['voters_id'])) {
			$errors[] = 'You must provide Voter\'s ID.';
		}

		if (empty($_POST['pwd'])) {
			$errors[] = 'You must provide password.';
		}
	}

	// check if Voter exists in the database
	$query = $db->query("SELECT * FROM voters WHERE voters_id = '$voter'");
	$result = mysqli_fetch_assoc($query);
	$resultCount = mysqli_num_rows($query);

	if (!empty($_POST['voters_id'])) {
		if ($resultCount == 0) {
			$errors[] = 'Voter doesn\'t exist in our database.';
		}
	}

	if (!empty($_POST['pwd'])) {
		if (!password_verify($password, $result['pwd'])) {
			$errors[] = 'Invalid password. Try again.';
		}
	}

	//Check for errors
	if (!empty($errors)) {
		echo display_errors($errors);
	} else {
		//Log User in
		$voterSession = $result['id'];
		loginVoter($voterSession);
	}
}
header('location: index.php');
