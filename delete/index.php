<?php
  session_start();
  require('../db.php');
  $data = $_POST;
  $mysqli = ConnectToDatabase();
  $id    = $data['id'];

  if(empty($_SESSION['notes']))
  {
    header('Location: ../');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
      $sql = "DELETE FROM notes 
              WHERE id=$id";

      $exe = $mysqli->query($sql)
        or die(json_encode(Array("error"=>mysqli_error($mysqli))));

      $out = json_encode(Array("status"=>"success","body"=>$note));
      echo $out;
  }
?>
