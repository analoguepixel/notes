<?php
  session_start();
  $input = $_POST;
  require_once $_SERVER["DOCUMENT_ROOT"] . '/api/db.php';
  $mysqli = ConnectToDatabase();

  $uid = $input["uid"];
  $note = $input["note"];
  $owner = true;

  $sql = "SELECT DISTINCT * FROM notes WHERE id=$note";
  $exe = $mysqli->query($sql)
    or die(mysqli_error($mysqli));

  // TODO: rewrite to check for num_rows and get $data from fetch_assoc drectly
  while($row = $exe->fetch_assoc()) {
    $myArray[] = $row;
  }
  $data = $myArray[0];

  if($data["uid"] != $uid)
  {
    $owner = false;

    // query the sharing table to see if current user is a guest
    // on this note
    $sql = "SELECT DISTINCT * FROM sharing WHERE note=$note";

    // return a json object
    $exe = $mysqli->query($sql)
      or die(mysqli_error($mysqli));

    if($exe->num_rows > 0)
    {
      $sharing = $exe->fetch_assoc();
      $data["editable"] = $sharing["editable"];
    }

    if($sharing["guest"] = $_SESSION["uid"])
    {
    }
    else
    {
      $data["title"] = "No permission";
      $data["body"] = "We're sorry, but you do not have permission to view this 
                       note. Please contact the owner of this note for permission
                       to view it. If the problem persists, please email us at.";
      $data["editable"] = false;
    }
  }
  else
  {
    if( ($data['locked'] == true) ||
        ($data["editable"] == 0) )
    {
      $data["editable"] = false;
    }
    else
    {
      $data["editable"] = true;
    }
    // a hack, reorganize editability code
    if($owner == true) $data["editable"] = true;

    $font = 'sans';
    if($data['font'] == 2)
    {
      $font = 'mono';
    }
    else if($data['font'] == 1)
    {
      $font = 'serif';
    }
    else
    {
      $font = 'sans';
    }
  }
  return json_encode($data);
?>
