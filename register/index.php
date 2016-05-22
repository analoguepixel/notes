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
      $password = $mysqli->real_escape_string($_POST['password']);
      $confirm  = $mysqli->real_escape_string($_POST['confirm']);
      $user     = $mysqli->real_escape_string($_POST['username']);
      $email    = $mysqli->real_escape_string($_POST['email']);
      $pass     = hash('sha256', $password . "salty");
      $confirm  = hash('sha256', $confirm . "salty");

      // return variables 
      $status = "good";

      if(empty($pass) ||
         empty($confirm) || 
         empty($user) ||
         empty($email))
      {
        $status = "Please be sure to fill out all fields.";
      }
      else if(strlen($user) < 6)
      {
        $status = "The minimum username length is six characters.";
      }
      else if(strlen($password) < 6)
      {
        $status = "The minimum password length is six characters.";
      }
      else if($pass != $confirm)
      {
        $status = "Please ensure that your passwords match.";
      }
      else if($user == "kwilkers")
      {
        $status = "Sorry. Registrstion is disabled at this time.";
      }
      else if($status == "good")
      {
        $sql = "INSERT INTO users
                VALUES(
                  0, 
                  0, 
                  '$user',
                  '$pass',
                  '$email');";
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
        }
        else
        {
          $status = "Invalid username/password combination";
        }
      }

    }
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <input type="password" 
                       name="confirm"
                       class="center loginput"
                       placeholder="confirm password">
                <br>
                <input type="text" 
                       name="email"
                       class="center loginput"
                       placeholder="email">
                <br>
                <input type="submit" 
                       class="center"
                       value="register">
                <br>
                <a href="../login">
                  <div class="link-button">
                    login 
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
