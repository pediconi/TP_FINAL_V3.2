<?php namespace session;

class Session
{

  public static function start()
  {
    if (!isset($_SESSION)) {
      session_start();
    }
  }

  public static function close()
  {
    if (isset($_SESSION)) {
      session_destroy();
      session_unset();

    } else {
      throw new Exception('Session::close() - $_SESSION is not started');
    }
  }

  public static function add($key, $value)
  {
    if (isset($_SESSION)) {
      if (isset($key) && !is_object($key) && !is_array($key) && trim($key) !== "" && isset($value) && trim($value) !== "") {
        $_SESSION[$key] = $value;

      } else {
        if (is_object($key)) {
          throw new Exception('Session::add() - $key is an object.');

        } elseif (is_array($key)) {
          throw new Exception('Session::add() - $key is an array.');

        } elseif ((!isset($key) || trim($key) === "") && (!isset($value) || trim($value) === "")) {
          throw new Exception('Session::add() - $key and $value are empty or null.');

        } elseif (!isset($key) || trim($key) === "") {
          throw new Exception('Session::add() - $key is empty or null.');

        } elseif (!isset($value) || trim($value) === "") {
          throw new Exception('Session::add() - $value is empty or null.');
        }
      }
    } else {
      throw new Exception('Session::add() - $_SESSION is not started');
    }
  }

  public static function remove($key)
  {
    if (isset($_SESSION)) {
      if (isset($key) && trim($key) !== "") {
        session_unset($key);

      } else {
        throw new Exception('Session::remove() - $key is empty or null.');
      }
    } else {
      throw new Exception('Session::remove() - $_SESSION is not started');
    }
  }

  public static function printAll()
  {
    if (isset($_SESSION)) {
      echo '<pre>';
      echo 'SESSION : ';
      print_r($_SESSION);
      echo '</pre>';

    } else {
      throw new Exception('Session::printAll() - $_SESSION is not started');
    }
  }

  public static function printOne($key)
  {
    if (isset($_SESSION)) {
      if (isset($key) && trim($key) !== "") {
        if (isset($_SESSION[$key])) {
          echo '<br> <pre>';
          echo 'SESSION : {';
          echo "<br> '$key': '$_SESSION[$key]'";
          echo '<br>}';
          echo '</pre>';

        } else {
          throw new Exception("Session::printOne() - KEY($key) doesn't exists in " . '$_SESSION');
        }
      } else {
        throw new Exception('Session::printOne() - $key is empty or null.');
      }
    } else {
      throw new Exception('Session::printOne() - $_SESSION is not started');
    }
  }

  public static function getSession()
  {
    if (isset($_SESSION)) {
      return $_SESSION;

    } else {
      throw new Exception('Session:getSession() - $_SESSION is not started');
    }
  }
}


?>