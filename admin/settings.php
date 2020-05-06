<?php
  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';
  include 'views/head.php';
  include 'views/navigation.php';

  // if (!is_logged_in()){
	// 	login_error_redirect();
	// }

	// if(!has_permission('admin')){
	// 	permission_error_redirect('index.php');
	// }
  
  // DECLARATIONS
  $i = 1;

  // DELETE USER
  if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE users SET deleted = 1 WHERE id = '$id'");
    header('Location: candidates.php');
    $_SESSION['success_flash'] = 'User has been deleted';
		header('Location: settings.php');
  }


  if (isset($_GET['add']) || isset($_GET['edit'])) {
    $firstname = isset($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):'';
		$lastname = isset($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):'';
    $email = isset($_POST['email'])?sanitize($_POST['email']):'';
    $password = isset($_POST['password'])?sanitize($_POST['password']):'';
    $confirm = isset($_POST['confirm'])?sanitize($_POST['confirm']):'';
		$permissions = isset($_POST['permissions'])?ucfirst(sanitize($_POST['permissions'])):'';

    $zero = 0;
    $errors = array();

    // EDIT USER
		if (isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$editQ = $db->query("SELECT * FROM users WHERE id = '$edit_id'");
      $user = mysqli_fetch_assoc($editQ);
      
      
      $firstname = isset($_POST['firstname']) && !empty($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):$user['firstname'];
      $lastname = isset($_POST['lastname']) && !empty($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):$user['lastname'];
      $email = isset($_POST['email']) && !empty($_POST['email'])?sanitize($_POST['email']):$user['email'];
      $password = isset($_POST['password']) && !empty($_POST['password'])?sanitize($_POST['password']):$user['password'];
      $permissions = isset($_POST['permissions']) && !empty($_POST['permissions'])?ucfirst(sanitize($_POST['permissions'])):$user['permissions'];
    }

    if ($_POST) {
      if (isset($_GET['add'])){
        $emailQuery = $db->query("SELECT firstname,lastname,email,password,permissions FROM users WHERE email = '$email'");
        $emailCount = mysqli_num_rows($emailQuery);
  
        if($emailCount != 0){
          $errors[] = 'Email already exists.';
        }
    
        $required = array('firstname', 'lastname', 'email', 'password', 'confirm', 'permissions');
        foreach ($required as $f) {
          if (empty($_POST[$f])) {
            $errors[] = 'You must fill out all fields.';
            break;
          }
        }
    
        if (strlen($password) < 6) {
          $errors[] = 'Password must be at least 6 characters.';
        }
    
        if ($password != $confirm) {
          $errors[] = 'Passwords do not match.';
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors[] = 'Enter a valid email';
        }
      }

      if (isset($_GET['edit'])) {
        if(!empty($password) && (strlen($password) < 6) || !empty($confirm) && (strlen($confirm) < 6)){
          $errors[] = 'Password must be at least 6 characters.';            		
        }

        if(!empty($password) && ($password != $confirm) || !empty($confirm) && ($password != $confirm)){
          $errors[] = 'Passwords do not match.';            		
        }
      }
        
      if(!empty($errors)){
        echo display_errors($errors);
      } else {
        // add user to database
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insertsql = "INSERT INTO users (firstname, lastname, email, password, permissions, deleted) VALUES ('$firstname', '$lastname', '$email', '$hashed', '$permissions', '$zero')";
        // $_SESSION['success_flash'] = 'User has been added';
        $updated = 'added';

        if (isset($_GET['edit'])) {
          if (empty($password)) {
            $insertsql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', permissions = '$permissions', deleted = '$zero' WHERE id = '$edit_id'";
          }	
          elseif(!empty($password) && ($password = $confirm)){
            $insertsql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', password = '$hashed', permissions = '$permissions', deleted = '$zero' WHERE id = '$edit_id'";
          }	
          $updated = 'updated';
          // $_SESSION['success_flash'] = 'User has been updated';	         					
        }

        $_SESSION['success_flash'] = 'User has been '.$updated;

        $db->query($insertsql);
        header('Location: users.php');
      }
    }
?>

<div class="container font-weight-bold">
    <div class="card rounded-lg shadow-lg" id="outline">
      <div class="card-header">
        <h2 class="text-center font-weight-bold"><?= ((isset($_GET['add']))?'Add A New':'Edit'); ?> User</h2>
      </div>

      <div class="card-body">
        <form action="settings.php?<?= ((isset($_GET['add']))?'add=1':'edit='.$edit_id) ?>" method="POST"> 
          <div class="form-group">
            <div class="row">
              <div class="col-md-4 mb-2">
                <label for="firstname">First Name *:</label>
                <input type="text" class="form-control text-capitalize" name="firstname" id="firstname" value="<?= $firstname; ?>">
              </div>
    
              <div class="col-md-4 mb-2">
                <label for="lastname">Last Name *:</label>
                <input type="text" class="form-control text-capitalize" name="lastname" id="lastname" value="<?= $lastname; ?>">
              </div>
    
              <div class="col-md-4 mb-2">
                <label for="email">Email *:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>">
              </div>

              <div class="col-md-4 mb-2">
                <label for="password">Password *:</label>
                <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>">
              </div>

              <div class="col-md-4 mb-2">
                <label for="confirm">Confirm Password *:</label>
                <input type="password" class="form-control" name="confirm" id="confirm" value="">
              </div>
    
              <div class="col-md-4 mb-2">
							<label for="permissions">Permissions *:</label>
<!--                            Permissions cannot be changed by just anyone-->
							<select name="permissions" id="permissions" class="form-control" <?= isset($_GET['edit'])?' disabled':''; ?>>
								<option value=""<?= $permissions == ''?' selected':''; ?>></option>
								<option value="Editor"<?= $permissions == 'Editor'?' selected':'';
								?>>Editor</option>
								<option value="Admin, Editor"<?= $permissions == 'Admin, Editor'?' selected':''; ?>>Admin</option>
							</select>
              </div>

            </div>
          </div>
        </div>
            
        <div class="card-footer">
          <div class="col-md-12 mb-2 clearfix mt-4">
            <div class="float-right">
              <a href="settings.php" class="btn btn-secondary mr-2"><span class="fa fa-times-circle"></span> Cancel</a>
              <button class="btn btn-success" type="submit"><?= isset($_GET['add'])?'<span class="fa fa-plus-circle"></span> Add':'<span class="fa fa-pen-fancy"></span> Edit'; ?> User</button>
            </div>
          </div>
        </div>
        </form>

    </div>
  </div>

<?php
  }
  else {
    $sql_user = "SELECT * FROM users WHERE deleted = 0";
    $result_user = $db->query($sql_user);
?>

<div class="container" style="position: relative">
    <div class="card rounded-lg shadow-lg" id="outline">
      <div class="card-header">
        <h1 class="font-weight-bolder text-center">Users List</h1>

        <hr>
        
        <a href="settings.php?add=1" class="btn btn-block btn-success"><i class="fa fa-user-plus mr-2"></i>Add User</a>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-borderless table-striped table-hover" id="dataTable">
            <thead>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Join Date</th>
                <th>Last Login</th>
                <th>Permissions</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Join Date</th>
                <th>Last Login</th>
                <th>Permissions</th>
                <th>Action</th>
              </tr>
            </tfoot>
    
            <tbody>
            <?php
              foreach ($result_user as $res):
              $user_id = $res['id'];
            ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $res['firstname'].' '.$res['lastname']; ?></</td>
                <td><?= $res['email']; ?></td>
                <td><?= pretty_date($res['join_date']); ?></td>
                <td><?= $res['last_login'] == '0000-00-00 00:00:00'?'Never':pretty_date($res['last_login']); ?></td>
                <td><span class="badge badge-pill badge-dark"><?= $res['permissions']; ?></span></td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-outline-success mr-2 view_user_data" data-id="<?= $user_id; ?>"><span class="fa fa-eye"></span> View</button>

                    <a href="settings.php?edit=<?= $user_id; ?>" class="btn btn-sm btn-outline-primary mr-2"><span class="fa fa-pen-fancy"></span> Edit</a>
                    <a href="settings.php?delete=<?= $user_id; ?>" class="btn btn-sm btn-outline-danger"><span class="fa fa-trash-alt"> Delete</span></a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>


<?php 
  include 'includes/user_viewmodal.php';
  } 
  include 'views/footer.php'; 
  ob_end_flush();
?>