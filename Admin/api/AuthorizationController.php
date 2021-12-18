<?php
  require_once 'DB.php';
  class AuthorizationController{
    static function create_profile($email, $password){
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return_error("Параметр email некорректный.");
      $password_len = env("PASSWORD_MIN_LENGTH",8);
      if(!$password || strlen($password)<$password_len) return_error("Длинна пароля должна быть не менее $password_len.");

      //хэширование пароля
      $hash = password_hash($password,PASSWORD_BCRYPT);

      $db = DB::connect();
      $sql = "INSERT INTO `adminusers` (`id`, `email`, `password`, `role`) VALUES (NULL,'$email','$hash',0)";
      $result = $db->query($sql);
      $db->close();
      if($result){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $hash;
      }
      return $result;
    }
    static function check_profile($email, $password){
      if(!isset($email) || !isset($password)) return false;
      $db = DB::connect();
      $sql = "SELECT `password` FROM `adminusers` WHERE `email`='$email' LIMIT 1";
      $result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
      $db->close();
      if(!$result || sizeof($result)==0) return false;
      $valid = password_verify($password ,$result[0]["password"]);
      if($valid){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $result[0]["password"];
      }
      return $valid;
    }
    static function load_profile(){
      if(!isset($_SESSION["email"]) || !isset($_SESSION["password"])) return false;
      $email = $_SESSION["email"];
      $hash= $_SESSION["password"];
      $db = DB::connect();
      $sql = "SELECT `password` FROM `adminusers` WHERE `email`='$email' LIMIT 1";
      $result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
      $db->close();
      if(!$result || sizeof($result)==0) return false;
      return $hash == $result[0]["password"];
    }
    static function unload_profile(){
      $_SESSION["password"] = null;
    }
    static function get_current_profile(){
      if(!isset($_SESSION["email"])) return "";
      $email = $_SESSION["email"];
      $db = DB::connect();
      $sql = "SELECT `name`, `email` FROM `adminusers` WHERE `email`='$email' LIMIT 1";
      $result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
      $db->close();
      return $result[0];
    }
  }