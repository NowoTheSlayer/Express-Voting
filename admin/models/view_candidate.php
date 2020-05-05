<?php
  // require_once $_SERVER['DOCUMENT_ROOT'].'/Projects/InProgress/Express Vote/core/init.php';

  if(isset($_POST['submit'])){
    $candid_id = isset($_POST['id'])?$_POST['id']:'';

    if($candid_id > 0){
      $db = new PDO('mysql:host=localhost;dbname=expressvote', 'root','');
      $view = "SELECT * FROM candidates WHERE id = :candid_id";
      
      $stmt = $db->prepare($view);
      $stmt->bindValue(":candid_id", $candid_id);

      if($stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        exit(json_encode(array('status'=>'success', 'data'=>$row)));
      }
    }
  }

  exit(json_encode(array('status'=>'fail', 'msg'=>'Failed to fetch data!')));
?>