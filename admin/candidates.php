<?php
	// include Database connection file 
  require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';
  include 'views/head.php';
  include 'views/navigation.php';
  
 
  // DELETE CANDIDATE
  if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE candidates SET deleted = 1 WHERE id = '$id'");
    header('Location: candidates.php');
    $_SESSION['success_flash'] = 'Candidate has been deleted';
  }


  // DECLARATIONS
  $i = 1;
  $dbpath ='';


	if (isset($_GET['add']) || isset($_GET['edit'])) {
    $position = isset($_POST['position']) && !empty($_POST['position'])?ucfirst(sanitize($_POST['position'])):'';
		$firstname = isset($_POST['firstname']) && !empty($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):'';
    $lastname = isset($_POST['lastname']) && !empty($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):'';
    $level = isset($_POST['level']) && !empty($_POST['level'])?sanitize($_POST['level']):'';
		$gender = isset($_POST['gender']) && !empty($_POST['gender'])?ucfirst(sanitize($_POST['gender'])):'';
    // $image = isset($_POST['image']) && !empty($_POST['image'])?sanitize($_POST['image']):'';
    $saved_image = '';
    $zero = 0;

    $errors = array();

    // EDIT CANDIDATE
		if (isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$candQ = $db->query("SELECT * FROM candidates WHERE id = '$edit_id'");
      $candidate = mysqli_fetch_assoc($candQ);
      if (isset($_GET['delete_image'])) {
        $image_url = $_SERVER['DOCUMENT_ROOT'].$candidate['image']; echo $image_url;
        unlink($image_url);
        $db->query("UPDATE candidates SET image = '' WHERE id = '$edit_id'");
        header('Location: candidates.php?edit='.$edit_id);
      }
      

      $position = isset($_POST['position']) && !empty($_POST['position'])?ucfirst(sanitize($_POST['position'])):$candidate['position'];
      $firstname = isset($_POST['firstname']) && !empty($_POST['firstname'])?ucfirst(sanitize($_POST['firstname'])):$candidate['firstname'];
      $lastname = isset($_POST['lastname']) && !empty($_POST['lastname'])?ucfirst(sanitize($_POST['lastname'])):$candidate['lastname'];
      $level = isset($_POST['level']) && !empty($_POST['level'])?sanitize($_POST['level']):$candidate['level'];
      $gender = isset($_POST['gender']) && !empty($_POST['gender'])?ucfirst(sanitize($_POST['gender'])):$candidate['gender'];

      $saved_image = !empty($candidate['image'])?$candidate['image']:'';
      $dbpath = $saved_image;
    }

    if ($_POST) {
      $errors = array();
      $required = array('position', 'firstname', 'lastname', 'level', 'gender');
      foreach($required as $field){
        if ($_POST[$field] == '') {
          $errors[] = 'All Fields With an Asterics are Required.';
          break;
        }
      }

      // IMAGE VALIDATION
      if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo'];
        $name = $photo['name'];
        $nameArray = explode('.',$name);
        $fileName = $nameArray[0];
        $fileExt = $nameArray[1];
        $mime = explode('/',$photo['type']);
        $mimeType = $mime[0];
        $mimeExt = $mime[1];
        $tmpLoc = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $allowed = array('png','jpg', 'jpeg', 'gif');
        $uploadName = md5(microtime()). '.' .$fileExt;
        $uploadPath = BASEURL. 'admin/images/uploaded/'.$uploadName;
        $dbpath = '/Projects/InProgress/Express Vote/admin/images/uploaded/'.$uploadName;
        if ($mimeType != 'image') {
          $errors[] = 'The file must be an image.';
        }
        if (!in_array($fileExt, $allowed)){
          $errors[] = 'The image extension must be a png, jpg, jpeg or gif.';
        }
        if ($fileSize > 15000000) {
          $errors[] = 'The file size must be under 15MB';
        }
        if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
          $errors[] = 'File extension does not match the file.';
        }
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      } else {
        // Upload file and insert into database
        if (!empty($_FILES)) {
          move_uploaded_file($tmpLoc,$uploadPath);
        }
        $sql_DB = "INSERT INTO candidates (position, firstname, lastname, level, gender, image, deleted) VALUES ('$position', '$firstname', '$lastname', '$level', '$gender', '$dbpath', '$zero')";
        // $_SESSION['success_flash'] = 'Candidate has been added';
        $updated = 'added';

        if (isset($_GET['edit'])) {
          $sql_DB = "UPDATE candidates SET position = '$position', firstname = '$firstname', lastname = '$lastname', level = '$level', gender = '$gender', image = '$dbpath', deleted = '$zero' WHERE  id = '$edit_id'";
          $updated = 'updated';
          // $_SESSION['success_flash'] = 'Candidate has been updated';
        }

        $_SESSION['success_flash'] = 'Candidate has been '.$updated;

        $db->query($sql_DB);
        header('Location: candidates.php');
      }
    }

?>

  <div class="container font-weight-bold" style="position: relative">
    <h2 class="text-center"><?= ((isset($_GET['add']))?'Add A New':'Edit'); ?> Candidate</h2>
    <hr>
    <form action="candidates.php?<?= ((isset($_GET['add']))?'add=1':'edit='.$edit_id) ?>" method="POST" enctype="multipart/form-data"> 
      <div class="form-group">
        <div class="row">
          <div class="col-md-4 mb-2">
            <label>Position *:</label>
            <select id="position" name="position" class="custom-select">
              <option value=""<?= $position == ''?' selected':''; ?>></option>
              <?php 
                $sql_post = "SELECT * FROM position";
                $result_post = $db->query($sql_post);
                foreach ($result_post as $cand):
                  echo move_uploaded_file($tmpLoc,$uploadPath);
              ?>
                <option value="<?= $cand['post']; ?>"<?= $position == $cand['post']?' selected':''; ?>><?= $cand['post']; ?></option>
                <?php endforeach; ?>
            </select>
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
            <label>Level *:</label>
            <select id="level" name="level" class="custom-select">
              <option value=""<?= $level == ''?' selected':''; ?>></option>
              <option value="100"<?= $level == '100'?' selected':''; ?>>100</option>
              <option value="200"<?= $level == '200'?' selected':''; ?>>200</option>
              <option value="300"<?= $level == '300'?' selected':''; ?>>300</option>
              <option value="400"<?= $level == '400'?' selected':''; ?>>400</option>
            </select>
          </div>

          <div class="col-md-4 mb-2">
            <label>Gender *:</label>
            <select id="gender" name="gender" class="custom-select">
              <option value=""<?= $gender == ''?' selected':''; ?>></option>
              <option value="Male"<?= $gender == 'Male'?' selected':''; ?>>Male</option>
              <option value="Female"<?= $gender == 'Female'?' selected':''; ?>>Female</option>
            </select>
          </div>

          <div class="col-md-4 mb-2">
            <label>Custom file:</label>
            <?php if($saved_image != ''): ?>
              <div class="text-center">
                <img src="<?= $saved_image; ?>" class="img-fluid" style="height:300px;" alt="Saved Image">
              </div>
              <a href="candidates.php?delete_image=1&edit=<?= $edit_id; ?>" class="text-danger card-link">Delete Image</a></a>
            <?php else: ?>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="photo" id="photo">
              <label class="custom-file-label" for="photo">Upload Image</label>
            </div>
            <?php endif; ?>
          </div>

          <div class="col-md-12 mb-2 clearfix mt-4">
            <div class="float-right">
              <a href="candidates.php" class="btn btn-secondary mr-2"><span class="fa fa-times-circle mr-2"></span>Cancel</a>
              <button class="btn btn-success" type="submit"><?= ((isset($_GET['add']))?'<span class="fa fa-plus-circle mr-2"></span>Add':'<span class="fa fa-pen-fancy mr-2"></span>Edit'); ?> Candidate</button>
            </div>
          </div>

        </div>
      </div>
    </form>
  </div>

<?php
  } 
  else {
    $sql_candid = "SELECT * FROM candidates WHERE deleted = 0";
    $result_candid = $db->query($sql_candid);
?>

  <div class="container-fluid" style="position: relative">
    <h1 class="font-weight-bolder text-center">Candidates List</h1>
    <hr><br>
    <a href="candidates.php?add=1" class="btn btn-block btn-success"><i class="fa fa-user-plus mr-2"></i>Add Candidate</a>
    <br>

    <div class="table-responsive">
      <table class="table table-borderless table-striped table-hover" id="dataTable">
        <thead>
          <tr>
            <th></th>
            <th>Position</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Level</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th>
            <th>Position</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Level</th>
            <th>Gender</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
        </tfoot>

        <tbody>
        <?php
          foreach ($result_candid as $res):
          $candid_id = $res['id'];
        ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $res['position']; ?></td>
            <td><?= $res['firstname']; ?></</td>
            <td><?= $res['lastname']; ?></td>
            <td><?= $res['level']; ?></td>
            <td><?= $res['gender']; ?></td>
            <td><img src="<?= $res['image']; ?>" class="img-thumbnail" style="width: 100px; height:100px;" alt="Image"></td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="candidates.php?edit=<?= $candid_id; ?>" class="btn btn-sm btn-outline-primary mr-2"><span class="fa fa-pen-fancy"></span></a>
                <a href="candidates.php?delete=<?= $candid_id; ?>" class="btn btn-sm btn-outline-danger"><span class="fa fa-trash-alt"></span></a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>
  </div>

<?php } include 'views/footer.php'; ?>