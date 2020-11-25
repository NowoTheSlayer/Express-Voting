<?php include 'views/head.php'; 

  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';

  // $sqlPost = "SELECT * FROM position";
  // $resultPost = $db->query($sqlPost);

  // $sqlCan = "SELECT * FROM candidates";
  // $resultCan = $db->query($sqlCan);

  // $sql = "SELECT
  //         CONCAT(candidates.firstname,' ',candidates.lastname) AS name,
  //         position.post
  //         FROM candidates
  //         INNER JOIN position
  //         ON candidates.position = position.post";
  // $sqlDB = $db->query($sql);
?>
  <h1 class="font-weight-bold text-center p-5">HOMEPAGE</h1>

  <section>
    <div class="card">
      <div class="card-header">

      </div>

      <div class="card-body">
        <div class="card-deck">
          <div class="row">
            <?php 
              $presult = $db->query("SELECT  * FROM position WHERE deleted = '0'");
              while ($parent = mysqli_fetch_assoc($presult)) :
                $parent_id = (int)$parent['parent_id'];
                $cresult = $db->query("SELECT * FROM candidates WHERE parent_id = '$parent_id' AND deleted = '0'");
            ?>

              <div class="col-lg-3 col-md-4 mb-5">
                <h3><?= $parent['post']; ?></h3>
                <?php 
                  while ($child = mysqli_fetch_assoc($cresult)) : 
                    $name = $child['firstname']. ' ' . $child['lastname'];
                ?>
                <div class="card bg-info mb-2 text-center">
                  <p class="card-text"><?= $name; ?></p>
                </div>
                <?php endwhile;?>
              </div>

            <?php endwhile; ?>
            </div>
            
        </div>
      </div>

      <div class="card-footer">

      </div>
    </div>
  </section>

<?php include 'views/footer.php'; ?>

<!-- <div class="card-columns">
    <div class="card bg-primary">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the first card</p>
      </div>
    </div>
    <div class="card bg-warning">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the second card</p>
      </div>
    </div>
    <div class="card bg-success">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the third card</p>
      </div>
    </div>
    <div class="card bg-danger">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the fourth card</p>
      </div>
    </div>  
    <div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the fifth card</p>
      </div>
    </div>
    <div class="card bg-info">
      <div class="card-body text-center">
        <p class="card-text">Some text inside the sixth card</p>
      </div>
    </div>
  </div> -->