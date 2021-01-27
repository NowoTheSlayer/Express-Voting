<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Private/Express Vote/core/init.php';

if (!isadmin_logged_in()) {
  header('Location: login.php');
}

include 'views/head.php';
include 'views/navigation.php';
?>

<div class="container">

  <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
    <li class="breadcrumb-item" class="active">Ballot Preview</li>
  </ul>

  <section>
    <div class="row">
      <div class="col-10" id="content"></div>
    </div>
  </section>
</div>

<script>
  $(function() {
    fetch();

    $(document).on('click', '.reset', function(e) {
      e.preventDefault();
      var desc = $(this).data('desc');
      $('.' + desc).iCheck('uncheck');
    });
  });

  function fetch() {
    $.ajax({
      type: 'POST',
      url: 'ballot_fetch.php',
      dataType: 'json',
      success: function(response) {
        $('#content').html(response).iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
      }
    });
  }
</script>
<?php include 'views/footer.php'; ?>