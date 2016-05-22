<?php
  session_start();
  require('./db.php');
  $data = json_decode(file_get_contents('php://input'), true);
  $mysqli = ConnectToDatabase();

  if(empty($_SESSION['notes']))
  {
    header('Location: ../');
  }

  $sql = "SELECT DISTINCT * FROM notes ORDER BY date DESC";
  $exe = $mysqli->query($sql)
    or die(json_encode(Array("error"=>mysqli_error($mysqli))));

  //TODO: assign exe output to array to give to client
  while($row = $exe->fetch_assoc()) {
    $myArray[] = $row;
  }
  $out = json_encode($myArray);
  echo $out;
?>
