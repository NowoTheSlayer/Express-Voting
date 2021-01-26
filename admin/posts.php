<?php
	ob_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';
	
	if (!isadmin_logged_in()){
    header('Location: login.php');
	}
	
  include 'views/head.php';
  include 'views/navigation.php';

  $sql = "SELECT * FROM position where deleted = 0";
  $result = $db->query($sql);

	$errors = array();
	$post_value = '';
	$i = 1;

	
	// DELETE POSITION
  if (isset($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $db->query("UPDATE position SET deleted = 1 WHERE id = '$id'");
    header('Location: posts.php');
    $_SESSION['success_flash'] = 'Position has been deleted';
  }


	//EDIT POSITION
	if (isset($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		$eresult = $db->query("SELECT * FROM position WHERE id = '$edit_id'");
		$ePost = mysqli_fetch_assoc($eresult);

		$post_value = isset($_POST['post'])?ucfirst(sanitize($_POST['post'])):$ePost['post'];
		$maxvote_val = isset($_POST['max_vote'])?$_POST['max_vote']:$ePost['max_vote'];
	}


	if (isset($_POST['add_submit'])){
		$post = ucfirst(sanitize($_POST['post']));
		$max_vote = ($_POST['max_vote']);
		$zero = 0;

		//check if position is blank
		if ($_POST['post'] == ''){
			$errors[] .= 'You must enter a post.';
		}

		// check if position exists in database
		$sqlExist = "SELECT * FROM position WHERE post = '$post'";
		if (isset($_GET['edit'])){
			$sqlExist = "SELECT * FROM position WHERE post = '$post' AND id! = '$edit_id'";
		}

		$rest = $db->query($sqlExist);
		$count = mysqli_num_rows($rest);
		if ($count > 0){
			$errors[] .= $post. ' already exists. Please choose another post.';
		}

		//display errors
		if(!empty($errors)){
			echo display_errors($errors);
		} else{
			$sql = "INSERT INTO position (post, max_vote, deleted) VALUES ('$post', $max_vote, $zero)";
			$updated = 'added';

			if (isset($_GET['edit'])){
				$sql = "UPDATE position SET post = '$post', max_vote = '$max_vote' WHERE  id = '$edit_id'";
				$updated = 'updated';
			}

			$_SESSION['success_flash'] = 'Position has been '.$updated;

			$db->query($sql);
			header('Location: posts.php');
		}
	}
?>



  <div class="container">
		<div class="card rounded-lg" id="outline">
			<div class="card-header">
				<h2 class="font-weight-bold text-center">Posts</h2>

				<hr>

				<div class="d-flex justify-content-center">
					<form class="form-inline" action="posts.php<?= isset($_GET['edit'])?'?edit='.$edit_id:'' ?>" method="POST">
						<div class="form-group text-center">
							<label for="post" class="mb-2 mr-sm-2 font-weight-bold"><?= isset($_GET['edit'])?'Edit':'Add A'; ?> Post :</label>
							<div class="text-center">
								
								<input type="text" name="post" id="post" class="form-control text-capitalize mb-2 mr-sm-2" value="<?= $post_value; ?>">

								<input type="number" name="max_vote" class="form-control mb-2" placeholder="Max Vote" value="<?= $maxvote_val; ?>">
	
								<?= isset($_GET['edit'])?'<a href="posts.php" class="btn btn-secondary mb-2 mr-sm-2"><i class="fa fa-times-circle mr-2"></i>Cancel</a>':''; ?>
								<button type="submit" name="add_submit" class="btn btn-success mb-2"><?= isset($_GET['edit'])?'<span class="fa fa-pen-fancy mr-2"></span>Edit':'<span class="fa fa-plus-circle mr-2"></span>Add'; ?> Post</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-borderless table-striped table-hover" id="dataTable">
						<thead>
							<th></th>
							<th>Post</th>
							<th>Maximum Vote</th>
							<th>Action</th>
						</thead>
						<tfoot>
							<th></th>
							<th>Post</th>
							<th>Maximum Vote</th>
							<th>Action</th>
						</tfoot>

						<tbody>
						<?php 
							foreach ($result as $res): 
							$post_id = $res['parent_id'];		
						?>
							<tr>
								<td><?= $i++; ?></td>
								<td><?= $res['post']; ?></td>
								<td><?= $res['max_vote']; ?></td>
								<td>
									<div class="btn-group btn-group-sm">
										<a href="posts.php?edit=<?= $post_id; ?>" class="btn btn-sm btn-outline-primary mr-2"><span class="fa fa-pen-fancy"></span> Edit</a>
										<a href="posts.php?delete=<?= $post_id; ?>" class="btn btn-sm btn-outline-danger"><span class="fa fa-trash-alt"></span> Delete</a>
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
	include 'views/footer.php'; 
	ob_end_flush();
?>