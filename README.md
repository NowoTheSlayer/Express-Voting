# Express Vote

 <div class="card">
      <div class="card-header">

      </div>

      <div class="card-body">
        <div class="card-deck">
          <div class="row">
            <?php 
              $candidate = '';
              $presult = $db->query("SELECT  * FROM position WHERE deleted = '0'");
              while ($parent = mysqli_fetch_assoc($presult)) :
                $parent_id = (int)$parent['parent_id'];
                $cresult = $db->query("SELECT * FROM candidates WHERE parent_id = '$parent_id' AND deleted = '0'");
            ?>

              <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                <h3 class="ml-3"><?= $parent['post']; ?></h3>
                <?php 
                  while ($child = mysqli_fetch_assoc($cresult)) : 
                    $checked = '';
                    if(isset($_SESSION['post'])){
                      $value = $_SESSION['post'];

                      if(is_array($value)){
                        foreach($value as $val){
                          if($val == $child['id']){
                            $checked = 'checked';
                          }
                        }
                      }
                      else{
                        if($value == $child['id']){
                          $checked = 'checked';
                        }
                      }
                    }

                    $name = $child['firstname']. ' ' . $child['lastname'];
                    $idd = $child['id'];

                    $input = ($parent['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.$slug.'" name="'.$slug."[]".'" value="'.$child['id'].'" '.$checked.'>' : '<input type="radio" class="flat-red '.$slug.'" name="'.($row['description']).'" value="'.$child['id'].'" '.$checked.'>';

                    $candidate .= '
                      <li>
                      '.$input.'<button type="button" class="btn btn-primary btn-sm btn-flat clist platform" data-platform="'.$chld['platform'].'" data-fullname="'.$child['firstname'].' '.$child['lastname'].'"><i class="fa fa-search"></i> Platform</button><img src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$child['firstname'].' '.$child['lastname'].'</span>
                      </li>
                    ';

                    echo '
											<div class="row">
												<div class="col-xs-12">
													<div class="box box-solid" id="'.$row['id'].'">
														<div class="box-header with-border">
															<h3 class="box-title"><b>'.$row['description'].'</b></h3>
														</div>
														<div class="box-body">
															<p>'.$instruct.'
																<span class="pull-right">
																	<button type="button" class="btn btn-success btn-sm btn-flat reset" data-desc="'.($row['description']).'"><i class="fa fa-refresh"></i> Reset</button>
																</span>
															</p>
															<div id="candidate_list">
																<ul>
																	'.$candidate.'
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										';

										$candidate = '';
                ?>
                <div class="card bg-info mb-2 py-2 text-center">
                  <p class="card-text"><?= $name; ?></p>
                  <!-- <img src="<?=$child['image']; ?>" class="rounded-circle mx-auto d-block" style="width: 150px; height:150px;" alt="Image"> -->
                  <br>
                  <!-- <form action=""> -->
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="vote_<?= $idd;?>" name="voteVal" value="<?= $idd; ?>">
                      <label class="custom-control-label" for="vote_<?= $idd;?>">Vote</label>
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