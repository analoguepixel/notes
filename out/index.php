<?php

  setcookie('user', '', time() - 3600, '/');
  setcookie('sid',  '', time() - 3600, '/');
  session_start();
  session_destroy();
  header('Location: ../');

?>
