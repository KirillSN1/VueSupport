<?php
  require_once 'DB.php';
  class AuthorizationController{
    static function create_profile($email, $password){
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return_error("Параметр email некорректный.");
      $password_len = env("PASSWORD_MIN_LENGTH",8);
      if(!$password || strlen($password)<$password_len) return_error("Длинна пароля должна быть не менее $password_len.");

      $db = DB::connect();
      $sql = "INSERT INTO `adminusers` (`id`, `email`, `password`, `role`) VALUES (NULL,'$email','$password',0)";
      $result = $db->query($sql);
      $db->close();
      if($result){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
      }
      return $result;
    }
    static function check_profile($email, $password){
      if(!isset($email) || !isset($password)) return false;
      $db = DB::connect();
      $sql = "SELECT id FROM `adminusers` WHERE `email`='$email' AND `password`='$password' LIMIT 1";
      $result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);
      $db->close();
      return boolval(sizeof($result));
    }
    /**
     * Проверяет профиль и сохраняет его в сессии, если он существут.
     */
    static function save_profile($email,$password){
      $result = self::check_profile($email,$password);
      if($result){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
      }
    }
  }