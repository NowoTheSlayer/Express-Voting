<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
ob_start();
include 'views/head.php';

if (isvoter_logged_in()) {
  header('Location: home.php');
}

// if(isset($_SESSION['Admin'])){
//   header('location: admin/index.php');
// }

if (isset($_SESSION['Voter'])) {
  header('location: home.php');
}
?>



  <h1 class="font-weight-bold text-center p-5">Express Vote</h1>

  <div class="card container mx-auto border rounded-lg shadow-lg">
    <div class="card-header">
      <h3 class="font-weight-bold text-center mb-4">Sign in to start your session</h3>
    </div>

    <div class="card-body">
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="voters_id">Voter ID:</label>
          <input type="text" class="form-control" name="voters_id" id="voters_id">
        </div>

        <div class="form-group">
          <label for="pwd">Password:</label>
          <input type="password" class="form-control" name="pwd" id="pwd">
        </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary btn-block" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
      </form>
    </div>
    
    <?php
  if (isset($_SESSION['error'])) {
    echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>" . $_SESSION['error'] . "</p>
			  	</div>
          ";
          unset($_SESSION['error']);
        }
        ?>
        </div>

<?php include 'includes/scripts.php' ?>
<?php include 'views/footer.php'; ?>