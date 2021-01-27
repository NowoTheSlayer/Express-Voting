<?php
  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';

  if (!isadmin_logged_in()){
    header('Location: login.php');
  }
  
  include 'views/head.php';
  include 'views/navigation.php';
  

  // DECLARATIONS
  $i = 1;
  $permitted_chars_id = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $gen_id = 'V-'.substr(str_shuffle($permitted_chars_id), 0, 5);

  $permitted_chars_key = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $gen_key = 'K'.substr(str_shuffle($permitted_chars_key), 0, 5);
   
  // DELETE VOTER
  if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE voters SET deleted = 1 WHERE id = '$id'");
    $_SESSION['success_flash'] = 'Candidate has been deleted';
    header('Location: voters.php');
  }


  if (isset($_GET['add']) || isset($_GET['edit'])) {
    $voters_id = isset($_POST['voters_id'])?ucfirst(sanitize($_POST['voters_id'])):'';
    $firstname = isset($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):'';
    $lastname = isset($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):'';
    $email = isset($_POST['email'])?sanitize($_POST['email']):'';
    $pwd = isset($_POST['pwd'])?sanitize($_POST['pwd']):'';
    // $status = isset($_POST['status']) && !empty($_POST['status'])?ucfirst(sanitize($_POST['status'])):'';
    $status = 0;

    $zero = 0;
    $errors = array();

    // EDIT CANDIDATE
    if (isset($_GET['edit'])){
      $edit_id = (int)$_GET['edit'];
      $voterQ = $db->query("SELECT * FROM voters WHERE id = '$edit_id'");
      $voter = mysqli_fetch_assoc($voterQ);

      $voters_id = isset($_POST['voters_id']) && !empty($_POST['voters_id'])?ucfirst(sanitize($_POST['voters_id'])):$voter['voters_id'];
      $firstname = isset($_POST['firstname']) && !empty($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):$voter['firstname'];
      $lastname = isset($_POST['lastname']) && !empty($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):$voter['lastname'];
      $email = isset($_POST['email']) && !empty($_POST['email'])?sanitize($_POST['email']):$voter['email'];
      $pwd = isset($_POST['pwd']) && !empty($_POST['pwd'])?sanitize($_POST['pwd']):$voter['pwd'];
      // $status = isset($_POST['status']) && !empty($_POST['status'])?ucfirst(sanitize($_POST['status'])):$voter['status'];
      $status = $voter['status'] == 'Voted'?'Voted':'Not Voted';
    }

    if ($_POST) {
      $errors = array();
      $required = array('voters_id', 'firstname', 'lastname', 'pwd');
      foreach($required as $field){
        if ($_POST[$field] == '') {
          $errors[] = 'All Fields With an Asterics are Required.';
          break;
        }
      }

      $sqlExist = "SELECT * FROM voters WHERE voters_id = '$voters_id'";
      if (isset($_GET['edit'])){
        $sqlExist = "SELECT * FROM voters WHERE voters_id = '$voters_id' AND id != '$edit_id'";
      }
      $rest = $db->query($sqlExist);
      $count = mysqli_num_rows($rest);
      if ($count > 0){
        $errors[] .= $voters_id. ' already exists. Please enter another ID';
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      } else {
        $hashed = password_hash($pwd, PASSWORD_DEFAULT);
        $sql_DB = "INSERT INTO voters (voters_id, firstname, lastname, email, pwd, status, deleted) VALUES ('$voters_id', '$firstname', '$lastname', '$email', '$hashed', '$status', '$zero')";
        // $_SESSION['success_flash'] = 'Voter has been added';
        $updated = 'added';

        if (isset($_GET['edit'])) {
          $sql_DB = "UPDATE voters SET voters_id = '$voters_id', firstname = '$firstname', lastname = '$lastname', email = '$email', pwd = '$hashed', status = '$status', deleted = '$zero' WHERE  id = '$edit_id'";
          $updated = 'updated';
          // $_SESSION['success_flash'] = 'Voter has been updated';
        }

        $_SESSION['success_flash'] = 'Voter has been '.$updated;

        $db->query($sql_DB);
        header('Location: voters.php');
      }
    }

?>


  <div class="container font-weight-bold">
    <div class="card rounded-lg shadow-lg" id="outline">
      <div class="card-header">
        <h2 class="text-center font-weight-bold"><?= isset($_GET['add'])?'Add A New':'Edit'; ?> Voter</h2>
      </div>

      <div class="card-body">
        <form action="voters.php?<?= ((isset($_GET['add']))?'add=1':'edit='.$edit_id) ?>" method="POST"> 
          <div class="form-group">
            <div class="row">
              <div class="col-md-4 mb-2">
                <label for="voters_id">ID *:</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="voters_id" id="voters_id" value="<?= $voters_id; ?>"<?= isset($_GET['edit'])?' readonly':''; ?>>
                  <div class="input-group-append">
                    <!-- ENABLE BUTTONS -->
                    <!-- <button type="button" class="btn btn-info ass" onclick="getElementById('voters_id').value='<?= $gen_id; ?>'"><i class="fa fa-sync-alt"></i></button>  
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('voters_id').value = ''"><i class="fa fa-backspace"></i></button>   -->
                    <!-- ENABLE BUTTONS -->
    
                    <!-- DISABLE BUTTONS -->
                    <button type="button" class="btn btn-info ass"<?= isset($_GET['edit'])?' disabled':''; ?> onclick="getElementById('voters_id').value='<?= $gen_id; ?>'"><i class="fa fa-sync-alt"></i></button>  
                    <button type="button" class="btn btn-danger"<?= isset($_GET['edit'])?' disabled':''; ?> onclick="document.getElementById('voters_id').value = ''"><i class="fa fa-backspace"></i></button>  
                    <!-- DISABLE BUTTONS -->
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-2">
                <label for="firstname">First Name *:</label>
                <input type="text" class="form-control text-capitalize" name="firstname" id="firstname" value="<?= $firstname; ?>">
              </div>
    
              <div class="col-md-4 mb-2">
                <label for="lastname">Last Name *:</label>
                <input type="text" class="form-control text-capitalize" name="lastname" id="lastname" value="<?= $lastname; ?>">
              </div>
    
              <div class="col-md-4 mb-2">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>">
              </div>
    
              <div class="col-md-4 mb-2">
                <label for="pwd">KEY *:</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="pwd" id="pwd" value="<?= $pwd; ?>"<?= isset($_GET['edit'])?' readonly':''; ?>>
                  <div class="input-group-append">
                    <!-- ENABLE BUTTONS -->
                    <button type="button" class="btn btn-info ass" onclick="getElementById('pwd').value='<?= $gen_key; ?>'"><i class="fa fa-sync-alt"></i></button>  
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('pwd').value = ''"><i class="fa fa-backspace"></i></button>  
                    <!-- ENABLE BUTTONS -->
    
                    <!-- DISABLE BUTTONS -->
                    <!-- <button type="button" class="btn btn-info ass"<?= isset($_GET['edit'])?' disabled':''; ?> onclick="getElementById('pwd').value='<?= $gen_key; ?>'"><i class="fa fa-sync-alt"></i></button>  
                    <button type="button" class="btn btn-danger"<?= isset($_GET['edit'])?' disabled':''; ?> onclick="document.getElementById('pwd').value = ''"><i class="fa fa-backspace"></i></button>   -->
                    <!-- DISABLE BUTTONS -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="col-md-12 mb-2 clearfix mt-4">
            <div class="float-right">
              <a href="voters.php" class="btn btn-secondary mr-2"><span class="fa fa-times-circle"></span> Cancel</a>
              <button class="btn btn-success" type="submit"><?= isset($_GET['add'])?'<span class="fa fa-plus-circle"></span> Add':'<span class="fa fa-pen-fancy"></span> Edit'; ?> Voter</button>
            </div>
          </div>
        </div>
        </form>

    </div>
  </div>

<?php
  }
  else {
    $sql_voter = "SELECT * FROM voters WHERE deleted = 0";
    $result_voter = $db->query($sql_voter);
?>

<div class="container" style="position: relative">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
      <li class="breadcrumb-item" class="active">Voters</li>
    </ul>

    <div class="card rounded-lg shadow-lg" id="outline">
      <div class="card-header">
        <a href="voters.php?add=1" class="btn btn-block btn-success"><i class="fa fa-user-plus mr-2"></i>Add Voter</a>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-borderless table-striped table-hover" id="dataTable">
            <thead>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Voters ID</th>
                <!-- <th>Voters KEY</th> -->
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>Name</th>
                <th>Voters ID</th>
                <!-- <th>Voters KEY</th> -->
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
    
            <tbody>
            <?php
              foreach ($result_voter as $res):
              $voter_id = $res['id'];
            ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $res['firstname'].' '.$res['lastname']; ?></</td>
                <td><?= $res['voters_id']; ?></td>
                <!-- <td><?= $res['pwd']; ?></td> -->
                <td><?= $res['email']; ?></td>
                <td><?= $res['status'] == 0 ? 'Not Voted' : 'Voted'; ?></td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-outline-success mr-2 view_voter_data" data-id="<?= $voter_id; ?>"><span class="fa fa-eye"></span> View</button>

                    <a href="voters.php?edit=<?= $voter_id; ?>" class="btn btn-sm btn-outline-primary mr-2"><span class="fa fa-pen-fancy"></span> Edit</a>
                    <a href="voters.php?delete=<?= $voter_id; ?>" class="btn btn-sm btn-outline-danger"><span class="fa fa-trash-alt"> Delete</span></a>
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
  include 'includes/voter_viewmodal.php';
  } 
  include 'views/footer.php';
  ob_end_flush();
?>