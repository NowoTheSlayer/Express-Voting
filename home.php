<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Private/Express Vote/core/init.php';
// if (!isvoter_logged_in()){
// 	header('Location: login.php');
// }

include 'views/head.php';
include 'views/navigation.php';
?>

<h1 class="font-weight-bold text-center p-5">HOMEPAGE</h1>

<div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <span class="message"></span>
</div>

<section class="content">
  <?php
  if (isset($_SESSION['error'])) {
  ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <ul>
        <?php
        foreach ($_SESSION['error'] as $error) {
          echo "
            <li>" . $error . "</li>
          ";
        }
        ?>
      </ul>
    </div>
  <?php
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    echo "
      <div class='alert alert-success alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4><i class='icon fa fa-check'></i> Success!</h4>
        " . $_SESSION['success'] . "
      </div>
    ";
    unset($_SESSION['success']);
  }

  ?>

  <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <span class="message"></span>
  </div>

  <?php
  $sql = "SELECT * FROM votes WHERE voters_id = '" . $voter_data['id'] . "'";
  $vquery = $db->query($sql);
  if ($vquery->num_rows > 0) {
  ?>
    <div class="text-center">
      <h3>You have already voted for this election.</h3>
      <a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">View Ballot</a>
    </div>
  <?php
  } else {
  ?>

    <!-- Voting Ballot -->
    <form action="submit_ballot.php" method="POST" id="ballotForm">
      <?php
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

        echo '
          <div class="card mb-3">
            <div class="card" id="' . $parent['id'] . '">
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
      ?>

      <div class="text-center">
        <button type="button" class="btn btn-success" id="preview"><i class="fa fa-file-text"></i>
          Preview
        </button>
        <button type="submit" class="btn btn-primary" name="vote"><i class="fa fa-check-square-o"></i>
          Submit
        </button>
      </div>
    </form>
  <?php } ?>
  <!-- End Voting Ballot -->

  <?php include 'includes/ballot_modal.php'; ?>

</section>


<?php include 'includes/scripts.php'; ?>
<script>
  $(function() {
    $('.content').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    $(document).on('click', '.reset', function(e) {
      e.preventDefault();
      var desc = $(this).data('desc');
      $('.' + desc).iCheck('uncheck');
    });

    // $(document).on('click', '.platform', function(e){
    // 	e.preventDefault();
    // 	$('#platform').modal('show');
    // 	var platform = $(this).data('platform');
    // 	var fullname = $(this).data('fullname');
    // 	$('.candidate').html(fullname);
    // 	$('#plat_view').html(platform);
    // });

    $('#preview').click(function(e) {
      e.preventDefault();
      var form = $('#ballotForm').serialize();
      if (form == '') {
        $('.message').html('You must vote atleast one candidate');
        $('#alert').show();
      } else {
        $.ajax({
          type: 'POST',
          url: 'preview.php',
          data: form,
          dataType: 'json',
          success: function(response) {
            if (response.error) {
              var errmsg = '';
              var messages = response.message;
              for (i in messages) {
                errmsg += messages[i];
              }
              $('.message').html(errmsg);
              $('#alert').show();
            } else {
              $('#preview_modal').modal('show');
              $('#preview_body').html(response.list);
            }
          }
        });
      }

    });

  });
</script>
<?php include 'views/footer.php'; ?>