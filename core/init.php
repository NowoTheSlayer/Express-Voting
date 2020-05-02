<?php
  $hostName = "localhost";
  $username = "root";
  $password = "";
  $dbname = "expressvote";

  $db = new mysqli($hostName, $username, $password, $dbname);
  if (mysqli_connect_errno()){
    echo 'Database connection failed with following errors: '. mysqli_connect_error();
    die();
  }

  session_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/config.php';
	require_once BASEURL.'helpers/helpers.php';


	// if (isset($_SESSION['User'])) {
	// 	$user_id = $_SESSION['User'];
	// 	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	// 	$user_data = mysqli_fetch_assoc($query);
	// 	$fn = explode(' ', $user_data['full_name']);
	// 	$user_data['first'] = $fn[0];
	// 	$user_data['last'] = $fn[1];
	// }
	// if (isset($_SESSION['user'])) {
	// 	$user_idd = $_SESSION['user'];
	// 	$query = $db->query("SELECT * FROM users WHERE id = '$user_idd'");
	// 	$user_data = mysqli_fetch_assoc($query);
	// 	$fn = explode(' ', $user_data['full_name']);
	// 	$user_data['first'] = $fn[0];
	// 	$user_data['last'] = $fn[1];
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
