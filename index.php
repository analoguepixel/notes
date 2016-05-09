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
    <title>Notes</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/skeleton.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php if($_SESSION["color"] == "dark") { ?>
      <link rel="stylesheet" type="text/css" href="css/dark.css">
    <?php } ?>
    <script src="/notes/js/jq.js"></script>
    <script src="app.js"></script>
</head>

<body>
    <div id="page" class="container">
        <div class="row">
            <ul class="nav">
              <li class="nav active">
                <a href="./">
                  <div class="link-button">
                    Notes
                  </div>
                </a>
              </li>
              <li>
                <a href="new/">
                <input id="new"
                       type="submit" 
                       class="center"
                       value="new">
                </a>
              </li>
              <?php
                if($_SESSION['notes'] == true)
                {
              ?>
                  <li class="nav logout active">
                      <a href="./out">
                        <div class="link-button">
                          Logout 
                        </div>
                      </a>
                  </li>
              <?php
                }
              ?>
              <li class="nav logout active">
                <a href="color/">
                  <div class="link-button color-toggle">
                    A 
                  </div>
                </a>
            </li>
          </ul>
        </div>

        <div class="page-body">
          <div class="row">
            <?php
              if($_SESSION['notes'] == true)
              {
            ?>

              <ul class="note-list" id="noteList">
              </ul>
            <?php
              }
              else
              {
            ?>
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
