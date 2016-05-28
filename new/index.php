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
    <meta name="theme-color" content="#ffa726">
    <link rel="icon" type="image/png" href="/icon.png">
    <title>Notes - New Note</title>

    <!-- include links -->
    <?php include('../resources/links.php');?>

    <!-- include scripts -->
    <script src="/js/jq.js"></script>
    <script>var id = 0;</script>
    <script src="/js/app.js"></script>
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
                 Title
            </h3>
          </div>
          <div class="row">
            <div id="text"
                 contenteditable
                 autofocus
                 class="notepad center">
            </div>
            <span id="noteStatus"
                  class="note-status">
            </span>
        </div>
    </div>
</body>

</html>
