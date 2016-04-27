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

  header("Location: " .  $_SERVER["HTTP_REFERER"]);
?>
