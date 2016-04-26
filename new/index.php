<?php
  session_start();
  if(empty($_SESSION['notes']))
  {
    header('Location: ../');
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['pin']))
    {
      if($_POST['pin']=="132465")
      {
        $_SESSION['notes'] = true;
      }
    }
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Will Means</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/skeleton.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="/notes/js/jq.js"></script>
    <script>var id = 0;</script>
    <script src="../js/app.js"></script>
</head>

<body>
    <div id="page" class="container">
        <div class="row">
            <ul class="nav">
              <li class="nav active">
                <a href="/notes/">
                  <input type="submit" 
                         class="center"
                         value="Notes">
                 </a>
              </li>
              <li>
              <input id="save"
                     type="submit" 
                     class="center"
                     value="save">
              </li>
              <li>
              <li class="nav logout active">
                <a href="../out/">
                  <input type="submit" 
                         class="center"
                         value="logout">
                </a>
              </li>
            </ul>
        </div>

        <div class="row">
          <h3  id="title"
               contenteditable
               autofocus
               class="title">
               Title
          </h3>
        </div>
        <div class="row">
          <span id="noteStatus"
                class="note-status">
          </span>
          <div id="text"
               contenteditable
               autofocus
               class="notepad center">
        </div>
    </div>
</body>

</html>
