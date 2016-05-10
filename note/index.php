<?php
  session_start();
  require('../db.php');
  $mysqli = ConnectToDatabase();
  if(empty($_SESSION['notes']) ||
    empty($_GET['id']))
  {
    header('Location: ../');
  }
  $id = $_GET["id"];


  $sql = "SELECT DISTINCT * FROM notes WHERE id=$id";
  $exe = $mysqli->query($sql)
    or die(mysqli_error($mysqli));

  while($row = $exe->fetch_assoc()) {
    $myArray[] = $row;
  }
  $data = $myArray[0];
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Note - <?=$data["title"]?></title>

    <!-- include links -->
    <?php include('../resources/links.php');?>

    <!-- include scripts -->
    <script src="/notes/js/jq.js"></script>
    <script>var id = <?=$id?></script>
    <script src="../js/app.js"></script>
</head>

<body>
    <div id="page" class="container">

      <?php require('../resources/nav.php');?>
      <div class="page-body">
        <div class="row title-row">
          <h3  id="title"
               contenteditable
               autofocus
               class="title">
               <?= $data["title"] ?>
          </h3>
          <div class="toggle-buttons">
            <div id="fntSans" 
                 class="font-select sans <?=$font=='sans'?'active':''?>">
              A
            </div>
            <div id="fntSerif" 
                 class="font-select serif <?=$font=='serif'?'active':''?>">
              A
            </div>
            <div id="fntMono"
                 class="font-select mono <?=$font=='mono'?'active':''?>">
              A
            </div>
          </div>
        </div>
        <div class="row">
          <div id="text"
               contenteditable
               autofocus
               class="notepad center <?=$font?>">
               <?= $data["body"] ?>
          </div>
          <span id="noteStatus"
                class="note-status">
          </span>
      </div>
    </div>
</body>

</html>
