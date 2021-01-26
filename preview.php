<?php include 'views/head.php';

ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Private/Express Vote/core/init.php';

$output = array('error' => false, 'list' => '');

$sql = "SELECT * FROM position";
$query = $db->query($sql);

while ($row = mysqli_fetch_assoc($query)) {

  $position = $row['post'];
  $pos_id = $row['parent_id'];
  if (isset($_POST[$position])) {
    if ($row['max_vote'] > 1) {
      if (count($_POST[$position]) > $row['max_vote']) {
        $output['error'] = true;
        $output['message'][] = '<li>You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['post'] . '</li>';
      } else {
        foreach ($_POST[$position] as $key => $values) {
          $cmquery = $db->query("SELECT * FROM candidates WHERE id = '$values'");
          $cmrow = mysqli_fetch_assoc($cmquery);
          $output['list'] .= "
							<div class='row votelist'>
								<span class='col-sm-4'><span class='pull-right'><b>" . $row['post'] . " :</b></span></span>
								<span class='col-sm-8'>" . $cmrow['firstname'] . " " . $cmrow['lastname'] . "</span>
							</div>
						";
        }
      }
    } else {
      $candidate = $_POST[$position];
      $csquery = $db->query("SELECT * FROM candidates WHERE id = '$candidate'");
      $csrow = mysqli_fetch_assoc($csquery);
      $output['list'] .= "
					<div class='row votelist'>
                      	<span class='col-sm-4'><span class='pull-right'><b>" . $row['post'] . " :</b></span></span>
                      	<span class='col-sm-8'>" . $csrow['firstname'] . " " . $csrow['lastname'] . "</span>
                    </div>
				";
    }
  }
}

echo json_encode($output);
