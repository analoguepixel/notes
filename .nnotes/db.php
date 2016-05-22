<?php
function ConnectToDatabase()
{
  // Used to connect to the database
  $db_location = 'localhost';
  $db_username = 'root';
  $db_password = 'blektopn';
  $db_database = 'notes';

  // Your database name is the same as your username
  $mysqli = new mysqli($db_location, $db_username, $db_password, $db_database);

  // Output error info if there was a connection problem
  if ($mysqli->connect_errno)
    die("Failed to connect to MySQL: ($mysqli->connect_errno) $mysqli->connect_error");
  return $mysqli;
}
?>

