<?php
  session_start();
  require('../db.php');
  $data = $_POST;
  $mysqli = ConnectToDatabase();
  $note = $mysqli->real_escape_string($data['note']);
  $title = $data['title'];
  $id    = $data['id'];

  if(empty($_SESSION['notes']))
  {
    header('Location: ../');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($note))
    {
      if(empty($title)) 
      {
        $title = 'untitled'; 
      }
      else
      {
        if($id > 0)
        {
          $sql = "UPDATE notes
                  SET title='$title', body='$note'
                  WHERE id=$id";
        }
        else
        {
          $sql = "INSERT INTO notes VALUES (0, 0, null, '$title', '$note' )";
        }

        $exe = $mysqli->query($sql)
          or die(json_encode(Array("error"=>mysqli_error($mysqli))));

        $out = json_encode(Array("status"=>"saved","body"=>$note));
        echo $out;
      }
    }
  }
?>
