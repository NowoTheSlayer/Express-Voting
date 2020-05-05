<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';

  

  $phoneData = isset($_POST['phoneData'])?$_POST['phoneData']:0;

  $sql_candid = "SELECT * FROM candidates WHERE deleted = 0";
  $result_candid = $db->query($sql_candid);

  while($row = mysqli_fetch_assoc($result_candid)): 
  $data = 
    '
    <div class="table-responsive">
      <h4 class="text-center">'.$row['position'].'</h4><br>
      <table class="table table-borderless table-hover table-sm">
        <tr>
          <th>Position :</th>
          <td>'.$row['position'].'</td>
        </tr>
        <tr>
          <th>Name :</th>
          <td>'.$row["firstname"]." ".$row["lastname"].'</td>            
        </tr>            
        <tr>
          <th>Level :</th>
          <td>'.$row["level"].'</td>            
        </tr> 
        <tr>
          <th>Gender :</th>
          <td>'.$row["gender"].'</td>            
        </tr>                     
      </table>
    </div>
    ';
  endwhile;
  echo $data;
?>