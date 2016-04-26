<?php
  session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['pin']))
    {
      if($_POST['pin']=="132798")
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
    <script src="/notes/js/app.js"></script>
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
            </ul>
        </div>

        <div class="row">
          <h4 class="center">
            <a href="./" 
               style="text-decoration: none">
                Notes
            </a>
          </h4>
        </div>
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
            <form method="POST">
              <input type="password" 
                     inputmode="numeric" 
                     name="pin"
                     maxlength="10"
                     class="center"
                     placeholder="PIN">
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
</body>

</html>
