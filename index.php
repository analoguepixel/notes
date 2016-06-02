<?php
  session_start();
  if(empty($_SESSION['notes']))
  {
    header("Location: login/");
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffa726">
    <link rel="icon" type="image/png" href="/icon.png">
    <title>Notes</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/skeleton.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php if($_SESSION["color"] == "dark") { ?>
      <link rel="stylesheet" type="text/css" href="css/dark.css">
    <?php } ?>
    <script src="js/jq.js"></script>
    <script src="app.js"></script>
</head>

<body>
    <div id="page" class="container">
      <?php require('resources/nav.php');?>

        <div class="page-body">
          <div class="row">
            <?php
              if($_SESSION['notes'] == true)
              {
            ?>

              <ul class="note-list sans" id="noteList">
              </ul>
            <?php
              }
              else
              {
            ?>
              <div class="row">
                <h1 class="center">Welcome to Mininote</h1>
                <p class="center">
                  Ready to take notes? Login or register below.
                </p>
                <p class="center">
                  Want ti find out more? <a href="about/">follow me!</a>
                </p>
              </div>
              <div class="row">
                <h3 class="center">login</h3>
              </div>
              <form method="POST" class="login" action="login.php">
                <input type="text" 
                       name="username"
                       class="center loginput"
                       placeholder="username">
                <br>
                <input type="password" 
                       name="password"
                       class="center loginput"
                       placeholder="password">
                <br>
                <input type="submit" 
                       class="center"
                       value="submit">
              </form>

            <?php
              }
            ?>
          </div>
        </div>
    </div>
</body>

</html>
