<?php
  session_start();
  if( $_SESSION["color"] == "dark")
  {
    $_SESSION["color"] = "light";
  }
  else
  {
    $_SESSION["color"] = "dark";
  }

  if(!empty($_SESSION['notes']))
  {
    require('../db.php');
    $mysqli = ConnectToDatabase();
    $sql = "UPDATE users 
            SET color='$_SESSION[color]' 
            WHERE id=$_SESSION[uid]";
    $exe = $mysqli->query($sql)
      or die(json_encode(Array("line"=>__LINE__, "error"=>mysqli_error($mysqli))));

    $out = $mysqli->insert_id;

  }

  header("Location: " .  $_SERVER["HTTP_REFERER"]);
?>
