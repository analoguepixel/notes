<?php
  session_start();
  require('./db.php');
  require('./resources/date.php');
  $data = json_decode(file_get_contents('php://input'), true);
  $mysqli = ConnectToDatabase();

  if(empty($_SESSION['notes']))
  {
    $out = Array(
      "status" => "error",
      "response" => "no user session exists"
    );
  }
  else
  {
    //$sql = "SELECT DISTINCT * FROM simple_notes_view WHERE uid=$_SESSION[uid] ORDER BY date DESC";
    $sql = "SELECT DISTINCT * FROM notes WHERE uid=$_SESSION[uid] ORDER BY date DESC";
    $exe = $mysqli->query($sql)
      or die(json_encode(Array("error"=>mysqli_error($mysqli))));

    //TODO: assign exe output to array to give to client
    while($row = $exe->fetch_assoc()) {
      $row["date"] = relativeTime($row["date"]);
      $row['body'] = preg_replace('/<[^>]*>/', ' ', $row['body']);
      $myArray[] = $row;
    }

    $sql = "SELECT DISTINCT * FROM guest_notes WHERE uid=$_SESSION[uid] ORDER BY date DESC";
    $exe = $mysqli->query($sql)
      or die(json_encode(Array("error"=>mysqli_error($mysqli))));

    //TODO: assign exe output to array to give to client
    while($row = $exe->fetch_assoc()) {
      $row["date"] = relativeTime($row["date"]);
      $row['body'] = preg_replace('/<[^>]*>/', ' ', $row['body']);
      $myArray[] = $row;
    }

    $out = $myArray;
  }
  $out = json_encode($out);
  echo $out;
?>
