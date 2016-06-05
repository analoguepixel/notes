<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/db.php';

  function logOut() {
    session_destroy();
    header('Location: /');
  }

  /*
   * function checkPersitentSession
   * requires session_id, uid
   * returns 1, -1 for success, failure, or other
   * checks for a record in the database storing persistent 
   * session_id and user records
   */
  function checkPersistentSession($sid, $uid) {
    echo 'start cps';
    $mysqli = ConnectToDatabase();
    $sql = "SELECT * FROM active_sessions 
            WHERE uid='$uid' AND id='$sid'";
    $exec = $mysqli->query($sql);
    echo 'cps queried';
    if( $exec->num_rows > 0 )
    {
      return 1;
    }
    else if( !empty($mysqli->error) )
    {
      return 0;
    }
    else
    {
      return -1;
    }
  }

  /*
   * function createPersitentSession
   * requires session_id, uid
   * returns 1, -1 for success, failure, or other
   * inserts a record into the database to store persistent 
   * session_id and user records so the cookies are not as trusted
   */
  function createPersistentSession($sid, $uid) {
    $mysqli = ConnectToDatabase();
    $sql = "INSERT INTO active_sessions 
              (id, uid, expiration)
            VALUES 
              ('$sid', '$uid', DATE_ADD(CURRENT_DATE, INTERVAL 1 WEEK))";
    $exec = $mysqli->query($sql);
    if( !empty($error = $mysqli->error) )
    {
      echo $error;
      return 0;
    }
    else if( isset($mysqli->insert_id) )
    {
      return 1;
    }
    else
    {
      return -1;
    }

  }


  /*
   * function setSession 
   * requires array( uid, user, color ) 
   * returns string 'good' for success, error string otherwise
   * initializes session
   * sets session variables to be properties of given array 
   *
   * TODO: set error string
   */
  function setSession($user, $createPersistent)
  {
    echo 'setting sesh';
    $_SESSION["notes"] = true;
    $_SESSION["uid"]   = $user["id"];
    $_SESSION["user"]  = $user["user"];
    $_SESSION["color"] = $user["color"];

    if( isset($createPersistent) &&
        $createPersistent == true )
    {
      $SESSION_LENGTH = time() + 60 * 60 * 24 * 7 * 2;
      setcookie('user', $user["user"], $SESSION_LENGTH, '/');
      setcookie('sid',  session_id(), $SESSION_LENGTH, '/');
      $x = createPersistentSession(session_id(), $user["id"]);
      echo 'persistent session: ' . $x;
    }
    return 'good';
  }


  /*
   * function login 
   * requires array( uid, sid ) || array( user, pass )
   * returns string 'good' for success, error string otherwise
   * validates login credentials
   * sets session variables to be properties of given array 
   */
  function login($user)
  {

    if( empty($mysqli) )
    {
      $mysqli = ConnectToDatabase();
    }
    
    // for validating from records in active_sessions table
    // persistent session format
    if( isset($user['user']) &&
        isset($user['sid']) )
    {
      echo 'ntl';

      // get validation details of session id in cookie
      $uid = $user['user'];
      $sid = $user['sid'];
      $sql = "SELECT id, uid, expiration
              FROM active_sessions
              WHERE id='$sid'";

      if( ($result = $mysqli->query($sql)) &&
          ($result->num_rows > 0) )
      {
        $sessionRecord = $result->fetch_assoc();
        echo 'about to get user';

        // get user details of provided username
        $sql = "SELECT id, 
                  user, 
                  pass,
                  color
                FROM users
                WHERE user='$uid';";

        // verify returned uname 
        if($result = $mysqli->query($sql))
        {
          $userRecord = $result->fetch_assoc();

          if($sessionRecord['uid'] == $userRecord['id'])
          {
            $status = setSession($userRecord);
          }
        // end mysql exec
        }
      // end checking valid rows
      }

    // end checking for session id and uid params
    }
    // for validating from records in users table
    // regular login format
    else if( isset($user['user']) &&
             isset($user['pass']) )
    {
      echo 'ftl';
      // login credentials
      $pass = $user['pass'];
      $user = $mysqli->real_escape_string($user['user']);
      $pass = hash('sha256', $pass . "salty");

      // return variables 
      $status = "";

      $sql = "SELECT id, 
                user, 
                pass,
                color
              FROM users
              WHERE user='$user';";
      if($result = $mysqli->query($sql))
      {

        // if username valid
        if($result->num_rows > 0)
        {
          $userObj = $result->fetch_assoc();

          // if password valid
          if($userObj["pass"] == $pass)
          {
            $status = setSession($userObj, true);
          }
          else
          {
            $status = 'invalid username/password combination';
          }
        }
        else
        {
          // bad user/password combo
          $status = 'invalid username/password combimation';
        }
      // end checking valid rows
      }
      else
      {
        $status = 'invalid username/password combimation';
      }
    // end checking for user and pass params
    }
    return $status;
  
  // end login
  }


?>
