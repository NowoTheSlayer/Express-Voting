<?php  

  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';
	include 'views/head.php';

	if(isset($_POST['vote'])){
		if(count($_POST) == 1){
			$_SESSION['error'][] = 'Please vote atleast one candidate';
		}
		else{
			$_SESSION['post'] = $_POST;
			$query = $db->query("SELECT * FROM position");
			$error = false;
			$sql_array = array();
			while($row = mysqli_fetch_assoc($query)){
				$position = $row['post'];
				$pos_id = $row['parent_id'];
				if(isset($_POST[$position])){
					if($row['max_vote'] > 1){
						if(count($_POST[$position]) > $row['max_vote']){
							$error = true;
							$_SESSION['error'][] = 'You can only choose '.$row['max_vote'].' candidates for '.$row['post'];
						}
						else{
							foreach($_POST[$position] as $key => $values){
								$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter_data['id']."', '$values', '$pos_id')";
							}

						}
						
					}
					else{
						$candidate = $_POST[$position];
						$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter_data['id']."', '$candidate', '$pos_id')";
					}

				}
				
			}

			if(!$error){
				foreach($sql_array as $sql_row){
					$db->query($sql_row);
				}

				unset($_SESSION['post']);
				$_SESSION['success'] = 'Ballot Submitted';

			}

		}

	}
	else{
		$_SESSION['error'][] = 'Select candidates to vote first';
	}

	header('location: home.php');

?>