<?php
  $hostName = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "expressvote";

  $db = new mysqli($hostName, $username, $password, $dbname);
  if (mysqli_connect_errno()){
    echo 'Database connection failed with following errors: '. mysqli_connect_error();
    die();
  }

  session_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once BASEURL.'helpers/helpers.php';


  // Admin Session
	if (isset($_SESSION['Admin'])) {
		$adminSession = $_SESSION['Admin'];
		$query = $db->query("SELECT * FROM users WHERE id = '$adminSession'");
		$admin_data = mysqli_fetch_assoc($query);
		// $fn = explode(' ', $user_data['full_name']);
		// $user_data['first'] = $fn[0];
		// $user_data['last'] = $fn[1];
	}
  
  // Voter Session
  if(isset($_SESSION['Voter'])){
    $voterSession = $_SESSION['Voter'];
    $query = $db->query("SELECT * FROM voters WHERE id = '$voterSession'");
		$voter_data = mysqli_fetch_assoc($query);
	}
	// else{
	// 	header('location: index.php');
	// 	exit();
	// }

	if (isset($_SESSION['success_flash'])) {
    echo '<div class="toast mt-5" data-autohide="false" style="position: absolute; top:0; right:0">';
    echo '  <div class="toast-header">';
    echo '    <strong class="mr-auto text-success">Success</strong>';
    echo '    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>';
    echo '  </div>';
    echo '  <div class="toast-body">';
    echo      $_SESSION['success_flash'];
    echo    '</div>';
    echo '</div>';
    unset($_SESSION['success_flash']);
  }

	if (isset($_SESSION['error_flash'])) {
    echo '<div class="toast mt-5" data-autohide="false" style="position: absolute; top:0; right:0">';
    echo '  <div class="toast-header">';
    echo '    <strong class="mr-auto text-danger">Error</strong>';
    echo '    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>';
    echo '  </div>';
    echo '  <div class="toast-body">';
    echo      $_SESSION['error_flash'];
    echo    '</div>';
    echo '</div>';
    unset($_SESSION['error_flash']);
  }

?>
