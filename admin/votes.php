<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';

if (!isadmin_logged_in()) {
  header('Location: login.php');
}

include 'views/head.php';
include 'views/navigation.php';
?>

<div class="container">

  <section class="content-header">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
      <li class="breadcrumb-item active">Votes</li>
    </ul>
  </section>

  <section>
    <div class="card" id="outline">

      <div class="card-body">
        <div class="box-header with-border mb-3">
          <a href="#reset" data-toggle="modal" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-refresh"></i> Reset</a>
        </div>

        <div class="table-responsive">
          <table class="table table-borderless table-striped table-hover" id="dataTable">
            <thead>
              <tr>
                <th>Position</th>
                <th>Candidate</th>
                <th>Voter</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Position</th>
                <th>Candidate</th>
                <th>Voter</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $sql = $db->query("SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast, voters.firstname AS votfirst, voters.lastname AS votlast FROM votes LEFT JOIN position ON position.parent_id=votes.position_id LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN voters ON voters.id=votes.voters_id");
              while ($res = mysqli_fetch_assoc($sql)) :
              ?>
                <tr>
                  <td><?= $res['post']; ?></td>
                  <td><?= $res['canfirst'] . ' ' . $res['canlast']; ?></td>
                  <td><?= $res['votfirst'] . ' ' . $res['votlast']; ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
include 'views/footer.php';
ob_end_flush();
?>