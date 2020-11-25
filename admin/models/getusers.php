<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Private/Express Vote/core/init.php';

  $usy = isset($_POST['usy'])?$_POST['usy']:'';


  if(isset($usy) and !empty($usy)){
    $sql_user = "SELECT * FROM users WHERE deleted = 0 AND id = $usy";
    $result_user = $db->query($sql_user);

    while($row = mysqli_fetch_assoc($result_user)):
    $name = $row['firstname'].' '.$row['lastname'];
    $email = $row['email'];
    $join_date = pretty_date($row['join_date']);
    $last_login = $row['last_login'] ==  NULL?'Never':pretty_date($row['last_login']);
    $permissions = $row['permissions'];

    $data = 
      '
      <div class="table-responsive">
        <table class="table table-borderless table-hover table-sm">
          <tr>
            <th>Name :</th>
            <td>'.$name.'</td>
          </tr>
          <tr>
            <th>Email :</th>
            <td>'.$email.'</td>            
          </tr>            
          <tr>
            <th>Joiin Date :</th>
            <td>'.$join_date.'</td>            
          </tr> 
          <tr>
            <th>Last Login :</th>
            <td>'.$last_login.'</td>            
          </tr>      
          <tr>
            <th>Permissions :</th>
            <td>'.$permissions.'</td>            
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