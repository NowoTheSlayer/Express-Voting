<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';
  
  if (!isadmin_logged_in()){
		header('Location: index.php');
  }
  
  include 'views/head.php';

  $hashed = $user_data['password'];
  $old_password = isset($_POST['old_password'])?sanitize($_POST['old_password']):'';
  $old_password = trim($old_password);
  $password = isset($_POST['password'])?sanitize($_POST['password']):'';
  $password = trim($password);
  $confirm = isset($_POST['confirm'])?sanitize($_POST['confirm']):'';
  $confirm = trim($confirm);
  $new_hashed = password_hash($password, PASSWORD_DEFAULT);
  $user_id = $user_data['id'];
  $errors = array();
?>


<div id="content" class="mt-5 pt-5">

<?php
  if ($_POST) {
    //form validation
    if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
      $errors[] = 'You must fill out all fields.';
    }

    // password is more than 6 characters
    if (strlen($password) < 6) {
      $errors[] = 'Password must be at least 6 characters.';
    }

    // check if new password matches confirm
    if ($password != $confirm) {
      $errors[] = 'Passwords do not match.';
    }

    if(!password_verify($old_password, $hashed)){
      $errors[] = 'Old password does not match our record.';
    }
    
    //Check for errors
    if(!empty($errors)){
      echo display_errors($errors);
    } else {
      //change password
      $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
      $_SESSION['success_flash'] = 'Your password has been updated';
      header('Location: index.php');
    }
  }
?>


      <!-- <h1 class="font-weight-bold text-center p-5">Change Password</h1> -->

      <div class="card container mx-auto border rounded-lg shadow-lg">
        <div class="card-header">
          <h3 class="font-weight-bold text-center mb-4">Change Password</h3>
        </div>

        <div class="card-body">
          <form action="change_password.php" method="POST">
            <div class="form-group">
              <label for="old_password">Old Password:</label>
              <input type="password" class="form-control" name="old_password" id="old_password" value="<?= $old_password; ?>">
            </div>

            <div class="form-group">
              <label for="password">New Password:</label>
              <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>">
            </div>

            <div class="form-group">
              <label for="confirm">Confirm New Password:</label>
              <input type="password" class="form-control" name="confirm" id="confirm" value="<?= $confirm; ?>">
            </div>
        </div>

        <div class="card-footer">
            <a href="index.php" class="btn btn-block btn-secondary"><span class="fa fa-times-circle"></span> Cancel</a>
            <button type="submit" class="btn btn-block btn-primary"><span class="fa fa-user-lock"></span> Change</button>
          </form>
          <br>
          
          <p class="float-left"><a target="_blank" href="/Private/Express Vote/index.php" alt="home">Visit Site</a></p>
        </div>
      </div>

<?php include 'views/footer.php'; ?>