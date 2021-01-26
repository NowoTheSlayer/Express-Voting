<?php include 'views/head.php'; 

  ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';
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

              <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                <h3 class="ml-3"><?= $parent['post']; ?></h3>
                <?php 
                  while ($child = mysqli_fetch_assoc($cresult)) : 
                    $name = $child['firstname']. ' ' . $child['lastname'];
                    $idd = $child['id']
                ?>
                <div class="card bg-info mb-2 py-2 text-center">
                  <p class="card-text"><?= $name; ?></p>
                  <!-- <img src="<?=$child['image']; ?>" class="rounded-circle mx-auto d-block" style="width: 150px; height:150px;" alt="Image"> -->
                  <br>
                  <!-- <form action=""> -->
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="vote_<?= $idd;?>" name="voteVal" value="<?= $idd; ?>">
                      <!-- <label class="custom-control-label" for="vote_<?= $idd;?>">Vote</label> -->
                    </div>
                  <!-- </form> -->
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