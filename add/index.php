<?php
  session_start();
  require('../db.php');
  $data = $_POST;
  $mysqli = ConnectToDatabase();
  $note = $mysqli->real_escape_string($data['note']);
  $title = $data['title'];
  $id    = $data['id'];
  $font  = -1;

  // set font value
  if($data['font'] == 'mono')
  {
    $font = 2;
  }
  else if($data['font'] == 'serif')
  {
    $font = 1;
  }
  else
  {
    $font = 0;
  }

  if(empty($_SESSION['notes']))
  {
    header('Location: ../');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    // checks for a set note, then title
    if(isset($note))
    {
      if(empty($title)) 
      {
        $title = 'untitled'; 
      }
      if($id > 0)
      {
        $sql = "UPDATE notes
                SET title='$title', body='$note', font=$font
                WHERE id=$id";
      }
      else
      {
        $sql = "INSERT INTO notes VALUES (0, 0, null, '$title', '$note', $font )";
      }

      $exe = $mysqli->query($sql)
        or die(json_encode(Array("error"=>mysqli_error($mysqli))));
      if(empty($id))
        $id = $mysqli->insert_id;

      // is this what is returned for confirmation?
      $out = json_encode(
        Array("status"=>"saved",
              "body"=>$note, 
              "id"=>$id,
        )
      );
      echo $out;
    }
  }
?>
