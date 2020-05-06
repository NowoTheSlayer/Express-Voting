<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';
  include 'views/head.php';
  // include 'views/navigation.php';

  // if (is_logged_in()){
	// 	header('Location: index.php');
  // }
  
  $email = isset($_POST['email'])?sanitize($_POST['email']):'';
  $email = trim($email);
  $password = isset($_POST['password'])?sanitize($_POST['password']):'';
  $password = trim($password);
  $errors = array();
  $success = array();
?>

  <div id="content" class="mt-5 pt-5">

<?php
  if ($_POST) {
    //form validation
    if (empty($_POST['email']) && empty($_POST['password'])) {
      $errors[] = 'You must provide Email and Password.';
    } else {
      if (empty($_POST['email'])) {
        $errors[] = 'You must provide email.';
      }

      if (empty($_POST['password'])) {
        $errors[] = 'You must provide password.';
      }

      // validate email
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'You must enter a valid email.';
      }
    }

    // password is more than 6 characters
    // if (strlen($password) < 6) {
    //     $errors[] = 'Password must be at least 6 characters.';
    // }

    // check if email exists in the database
    $query = $db->query("SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);
    $userCount = mysqli_num_rows($query);

    if (!empty($_POST['email'])) {
      if ($userCount == 0) {
        $errors[] = 'Email doesn\'t exist in our database.';
      }
    }

    if (!empty($_POST['password'])) {
      if(!password_verify($password, $user['password'])){
        $errors[] = 'Invalid password. Try again.';
      }
    }

    //Check for errors
    if(!empty($errors)){
      echo display_errors($errors);
    } else {
      //Log User in
      $user_id = $user['id'];
      login($user_id);
    }
  }
?>


      <h1 class="font-weight-bold text-center p-5">Express Vote - Admin Login</h1>

      <div class="card container mx-auto border rounded-lg shadow-lg">
        <div class="card-header">
          <h3 class="font-weight-bold text-center mb-4">Login</h3>
        </div>

        <div class="card-body">
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>" required>
            </div>
    
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>
    
            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
              <label class="custom-control-label" for="customCheck">Remember Me</label>
            </div>
        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-block btn-primary" value="Login">
          </form>
          <br>
          <p class="float-left"><a target="_blank" href="/Projects/InProgress/Express Vote/index.php" alt="home">Visit Site</a></p>
        </div>
      </div>

<?php include 'views/footer.php'; ?>




<!-- https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php -->