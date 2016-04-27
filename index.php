<?php
  session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['pin']))
    {
      $pin = $_POST['pin'];
      $pin = hash('sha256', $pin);
      $key = "b8ba5925257ad206e5f7bc35b20611ff51d595bfd332e904e41bf93797744985";
      if($pin == $key)
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
    <?php if($_SESSION["color"] == "dark") { ?>
      <link rel="stylesheet" type="text/css" href="css/dark.css">
    <?php } ?>
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
              <li class="nav logout active">
                <a href="color/">
                  <div class="link-button color-toggle">
                    A 
                  </div>
                </a>
            </li>
          </ul>
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
            <div class="row">
              <h3 class="center">PIN</h3>
            </div>
            <form method="POST" class="login">
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
