<?php
  session_start();
  require('../db.php');
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
    $data = $_POST;
    $user  = $_SESSION["uid"];
    $guest = $data["guest"];
    $guest = $mysqli->real_escape_string($data['guest']);
    $note  = $data["note"];


    // get uid of submitted guest 
    $sql = "SELECT DISTINCT * FROM users WHERE user='$guest'";
    $exe = $mysqli->query($sql)
      or die(json_encode(Array("line"=>__LINE__, "error"=>mysqli_error($mysqli))));

    $guest = $exe->fetch_assoc();
    $guest = $guest["id"];


    // confirm that no records exist
    $sql = "SELECT DISTINCT * 
            FROM sharing 
            WHERE uid=$user AND
              note=$note AND
              guest=$guest";
    $exe = $mysqli->query($sql)
      or die(json_encode(Array("line"=>__LINE__, "error"=>mysqli_error($mysqli))));

    echo "test";
    if($exe->num_rows > 0)
    {
      $out = 
        json_encode(
          Array("line"=>__LINE__, 
            "error"=>"you already have shared this item"
          )
      );

    }
    else
    {
      // share with guest 
      $sql = "INSERT INTO 
              notes.sharing (uid, note, guest)
              VALUES ($user, $note, $guest)";
      $exe = $mysqli->query($sql)
      or die(json_encode(Array("line"=>__LINE__, "error"=>mysqli_error($mysqli))));

      $out = $mysqli->insert_id;
    }
  }
  $out = json_encode($out);
  echo $out;
?>
