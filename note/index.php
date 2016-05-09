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
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Note - <?=$data["title"]?></title>
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <?php if($_SESSION["color"] == "dark") { ?>
      <link rel="stylesheet" type="text/css" href="../css/dark.css">
    <?php } ?>
    <script src="/notes/js/jq.js"></script>
    <script>var id = <?=$id?></script>
    <script src="../js/app.js"></script>
</head>

<body>
    <div id="page" class="container">
        <div class="row">
            <ul class="nav">
              <li class="nav active">
                <a href="/notes/">
                    <div class="link-button">
                       Notes
                    </div>
                 </a>
              </li>
              <li>
              <input id="save"
                     type="submit" 
                     class="center"
                     value="save">
              </li>
              <li>
              <input id="delete"
                     type="submit" 
                     class="center"
                     value="delete">
             </li>
                <li class="nav logout active">
                  <a href="../out/">
                    <div class="link-button">
                      Logout 
                    </div>
                  </a>
              </li>
                <li class="nav logout active">
                  <a href="../color/">
                    <div class="link-button color-toggle">
                      A 
                    </div>
                  </a>
              </li>
            </ul>
        </div>

        <div class="page-body">
        <div class="row title-row">
          <h3  id="title"
               contenteditable
               autofocus
               class="title">
               <?= $data["title"] ?>
          </h3>
          <span id="noteStatus"
                class="note-status">
          </span>
        </div>
        <div class="row">
          <div id="text"
               contenteditable
               autofocus
               class="notepad center">
               <?= $data["body"] ?>
        </div>
    </div>
    </div>
</body>

</html>
