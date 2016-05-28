<?php
  session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['password']) && isset($_POST['username']))
    {
      require('../db.php');
      $data = json_decode(file_get_contents('php://input'), true);
      $mysqli = ConnectToDatabase();

      // login credentials
      $pass = $_POST['password'];
      $user = $mysqli->real_escape_string($_POST['username']);
      $pass = hash('sha256', $pass . "salty");

      // return variables 
      $status = "";

      $sql = "SELECT id, 
                user, 
                pass 
              FROM users
              WHERE user='$user';";
      $result = $mysqli->query($sql)
        or die(
          json_encode(
            Array(
              "status"=>"status",
              "error"=>$mysqli->error
            )
          )
        );

      if($result->num_rows > 0)
      {
        $userObj = $result->fetch_assoc();
        if($userObj["pass"] == $pass)
        {
          $_SESSION["notes"] = true;
          $_SESSION["uid"]   = $userObj["id"];
          $_SESSION["user"]  = $userObj["username"];
          header("Location: ../index.php");
        }
        else
        {
          $status = "Invalid username/password combination";
        }
      }
      else
      {
        $status = "Invalid username/password combination";
      }
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
