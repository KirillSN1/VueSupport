<?php
  class DB{
    static function connect(){
      $mysqlidb = new mysqli($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASSWORD"],$_ENV["DB_NAME"]);
      if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      $mysqlidb->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
      return $mysqlidb;
    }
  }