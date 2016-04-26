<?php
  session_start();
  require('../db.php');
  echo file_get_contents('php://input');
  //$data = json_decode(file_get_contents('php://input'), true);
  $data = $_POST;
  $mysqli = ConnectToDatabase();
  $note = $mysqli->real_escape_string($data['note']);
  $title = $data['title'];
  $id    = $data['id'];
  echo $title;
  print_r($data);

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
          echo "UPDATING";
          $sql = "UPDATE notes
                  SET title='$title', body='$note'
                  WHERE id=$id";
        }
        else
        {
          echo "INSERTING";
          echo $id . "\n\n";
          $sql = "INSERT INTO notes VALUES (0, 0, null, '$title', '$note' )";
        }

        $exe = $mysqli->query($sql)
          or die(json_encode(Array("error"=>mysqli_error($mysqli))));

        $out = json_encode(Array("status"=>"success","body"=>$note));
        echo $out;
      }
    }
  }
?>
