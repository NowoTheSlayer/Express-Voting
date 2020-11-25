<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';

  $voty = isset($_POST['voty'])?$_POST['voty']:'';


  if(isset($voty) and !empty($voty)){
    $sql_voter = "SELECT * FROM voters WHERE deleted = 0 AND id = $voty";
    $result_voter = $db->query($sql_voter);

    while($row = mysqli_fetch_assoc($result_voter)):
    $name = $row['firstname'].' '.$row['lastname'];
    $voters_id = $row['voters_id'];
    $voters_key = $row['pwd'];
    $email = $row['email'];
    $status = $row['status'];

    $data = 
      '
      <div class="table-responsive">
        <table class="table table-borderless table-hover table-sm">
          <tr>
            <th>Name :</th>
            <td>'.$name.'</td>
          </tr>
          <tr>
            <th>Voters ID :</th>
            <td>'.$voters_id.'</td>            
          </tr>            
          <tr>
            <th>Voters KEY :</th>
            <td>'.$voters_key.'</td>            
          </tr> 
          <tr>
            <th>Email :</th>
            <td>'.$email.'</td>            
          </tr>      
          <tr>
            <th>Status :</th>
            <td>'.$status.'</td>            
          </tr>                 
        </table>
      </div>
      ';
    endwhile;
    echo $data;
  }
  else {
  echo '<center><ul class="list-group"><li class="list-group-item">'.'Nothing to show'.'</li></ul></center>';
  }
?>