<?php
	function display_errors($errors){
		$display = '<ul class="container-fluid mx-5 list-unstyled ">';
		$display = '<div class="container">';
		foreach ($errors as $error){
			$display .= '<div class="alert alert-danger alert-dismissible fade show">';
				// $display .= '<li class="text-danger">'.$error.'</li>';
				$display .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				$display .= '<li class="text-danger list-unstyled">'.$error.'</li>';
			$display .= '</div>';
		}
		// $display .= '</ul>';
		$display .= '</div>';
		return $display;


		// $display = '<div class="toast mt-5" data-autohide="false" style="position: absolute; top:0; right:0">';
		// foreach ($errors as $error){
		// 	$display .= '  <div class="toast-header">';
		// 	$display .= '    <strong class="mr-auto text-danger">Error</strong>';
		// 	$display .= '    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>';
		// 	$display .= '  </div>';
		// 	$display .= '  <div class="toast-body">';
		// 	$display .=      $error;
		// 	$display .=    '</div>';
		// }
		// $display .= '</div>';
		// return $display;
	}

	function sanitize($dirty){
		return htmlentities($dirty, ENT_QUOTES, "UTF-8");
		// return htmlentities($dirty, ENT_HTML5, "UTF-8"); 
		// return trim($dirty);
		// return stripslashes($dirty);
		// return htmlspecialchars($dirty);
	}

	// function money($number){
	// 	return '$'.number_format($number,2);
	// }

	function login($user_id){
		$_SESSION['User'] = $user_id;
		global $db;
		date_default_timezone_set("Africa/Lagos");
		$date = date("Y-m-d h:i:s");
		$db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");

		$_SESSION['success_flash'] = 'You are now logged in!';
		header('Location: index.php');
	}

	function is_logged_in(){
		if (isset($_SESSION['User']) && $_SESSION['User'] > 0) {
			return true;
		}
		return false;
	}

	function login_error_redirect($url = 'login.php'){
		$_SESSION['error_flash'] = 'You must be logged in to access that page';
		header('Location: ' .$url);
	}

	function permission_error_redirect($url = 'login.php'){
		$_SESSION['error_flash'] = 'You do not have permission to access that page';
		header('Location: ' .$url);
	}

	function has_permission($permission = 'Admin'){
		global $user_data;
		$permissions = explode(',', $user_data['permissions']);
		// $permissions = $user_data['permissions'];
		if (in_array($permission, $permissions, true)) {
			return true;
		}
		return false;
	}

	function pretty_date($date){
		date_default_timezone_set("Africa/Lagos");
		return date("M d, Y h:i A", strtotime($date));
	}
?>
