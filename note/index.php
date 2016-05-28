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
  $owner = true;


  $sql = "SELECT DISTINCT * FROM notes WHERE id=$id";
  $exe = $mysqli->query($sql)
    or die(mysqli_error($mysqli));

  while($row = $exe->fetch_assoc()) {
    $myArray[] = $row;
  }
  $data = $myArray[0];


  if($data["uid"] != $_SESSION["uid"])
  {
    $owner = false;

    // query the sharing table to see if current user is a guest
    // on this note
    $sql = "SELECT DISTINCT * FROM sharing WHERE note=$id";
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffa726">
    <link rel="icon" type="image/png" href="/icon.png">
    <title>Note - <?=$data["title"]?></title>

    <!-- include links -->
    <?php include('../resources/links.php');?>

    <!-- include scripts -->
    <script src="/js/jq.js"></script>
    <script>var id = <?=$id?></script>
    <script src="/js/app.js"></script>
</head>

<body>
    <div id="page" class="container">

      <?php require('../resources/nav.php');?>

      <div class="page-body">
        <div class="row title-row">
          <h3  id="title"
               <?= ($data["editable"])?"contenteditable":""?>
               class="title">
               <?= $data["title"] ?>
          </h3>
          <div class="toggle-buttons <?=($data["editable"])?:"hidden"?>">
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
        <?php 
          if($owner)
          {
        ?>
            <div class="row sharing-row">
              <ul id="guest-list" class="sharing">
                <li>
                  <input type="text" id="new-guest" class="sharing-textbox">

                </li>
              </ul>
            </div>
        <?php
          }
        ?>
        <div class="row">
          <div id="text"
               <?= ($data["editable"])?"contenteditable autofocus":""?>
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
