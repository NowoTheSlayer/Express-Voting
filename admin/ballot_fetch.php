<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Private/Express Vote/core/init.php';

if (!isadmin_logged_in()) {
  header('Location: login.php');
}

include 'views/head.php';
// include 'views/navigation.php';

$output = '';
$candidate = '';
      $presult = $db->query("SELECT  * FROM position WHERE deleted = '0'");
      while ($parent = mysqli_fetch_assoc($presult)) :
        $parent_id = (int)$parent['parent_id'];
        $cresult = $db->query("SELECT * FROM candidates WHERE parent_id = '$parent_id' AND deleted = '0'");
        while ($child = mysqli_fetch_assoc($cresult)) :
          $checked = '';
          $slug = $parent['post'];
          if (isset($_SESSION['post'])) {
            $value_data = $_SESSION['post'];

            if (is_array($value_data)) {
              foreach ($value_data as $val) {
                if ($val == $child['id']) {
                  $checked = 'checked';
                }
              }
            } else {
              if ($value_data == $child['id']) {
                $checked = 'checked';
              }
            }
          }

          $name = $child['firstname'] . ' ' . $child['lastname'];
          $input = $parent['max_vote'] > 1 ? '<input type="checkbox" class="flat-red ' . $slug . '" name="' . $slug . "[]" . '" value="' . $child['id'] . '" ' . $checked . '>' : '<input type="radio" class="flat-red ' . $slug . '" name="' . $parent['post'] . '" value="' . $child['id'] . '" ' . $checked . '>';
          $image = (!empty($child['image'])) ? $child['image'] : 'images/profile.jpg';
          $candidate .= '
            <li>
              ' . $input . '<img src="' . $image . '" height="100px" width="100px" class="clist rounded-circle"><span class="cname clist">' . $name . '</span>
            </li>
          ';
        endwhile;

        $instruct = ($row['max_vote'] > 1) ? 'You may select up to ' . $row['max_vote'] . ' candidates' : 'Select only one candidate';

        $output .= '
          <div class="card mb-3">
            <div class="card" id="' . $parent['parent_id'] . '">
              <div class="card-header">
                <h3 class="font-weight-bold box-title">' . $parent['post'] . '</h3>
              </div>
              <div class="card-body">
                <p>' . $instruct . '
                  <span class="float-right">
                    <button type="button" class="btn btn-success btn-sm reset" data-desc="' . $parent['post'] . '"><i class="fa fa-refresh"></i> Reset</button>
                  </span>
                </p>
              </div>
              <div id="candidate_list">
                <ul>
                  ' . $candidate . '
                </ul>
              </div>
            </div>
          </div>
        ';

        $candidate = '';

      endwhile;

      echo json_encode($output);
