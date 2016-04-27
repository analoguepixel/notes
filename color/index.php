<?php
  session_start();
  if( $_SESSION["color"] == "light")
  {
    $_SESSION["color"] = "dark";
  }
  else
  {
    $_SESSION["color"] = "light";
  }

  header("Location: " .  $_SERVER["HTTP_REFERER"]);
?>
