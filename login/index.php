<?php
  session_start();
  require_once $_SERVER["DOCUMENT_ROOT"] . '/db.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/resources/fns.php';

  if( isset($_COOKIE["sid"]) &&
      isset($_COOKIE["user"]) &&
      $_SERVER['REQUEST_METHOD'] != 'POST' )
  {
    echo ' cookie ';
    $cookieId = $_COOKIE["sid"];
    echo $cookieId;
    print_r($_COOKIE);
    $user = Array(
      "user" => $_COOKIE['user'],
      "sid"  => $cookieId
    );
    $status = login($user);
    if($status == 'good')
    {
      header('Location: /');
    }

  }
  else if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    //echo 'just get';
  }
  else
  {
    //session_start();
  }

  // if login data sent
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    echo 'POST';
    if( isset($_POST['password']) &&
         isset($_POST['username']) )
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $mysqli = ConnectToDatabase();
      $user = Array(
        "user" => $_POST['username'],
        "pass" => $_POST['password']
      );
      $status = login($user);
      if($status == 'good')
      {
        header('Location: /');
      }

    }
    else
    {
      $status = 'please provide a username and password';
    }
  }


?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffa726">
    <title>Notes</title>
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <?php if($_SESSION["color"] == "dark") { ?>
      <link rel="stylesheet" type="text/css" href="../css/dark.css">
    <?php } ?>
    <script src="/notes/js/jq.js"></script>
    <script src="app.js"></script>
</head>

<body>
    <div id="page" class="container">
        <div class="row">
            <ul class="nav">
              <li class="nav active">
                <a href="../">
                  <div class="link-button">
                    Notes
                  </div>
                </a>
              </li>
              <li class="nav logout active">
                <a href="../color">
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
                <h1 class="center">Welcome to Mininote</h1>
                <p class="center" style="width: 65%">
                  Ready to take notes? Login or register below.
                  Want to find out more? <a href="/about/">follow me!</a>
                </p>
              </div>
              <div class="row">
              <div class="row">
                <h3 class="center"></h3>
                <span class="center message">
                <?=$status?>
                </span>
              </div>
              <form method="POST" class="login">
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
                       class="center button button-primary"
                       value="login">
                <br>
                <a href="../register">
                  <div class="link-button">
                    register
                  </div>
                </a>
              </form>
            <?php
              }
            ?>
          </div>
        </div>
    </div>
</body>

</html>
