<?php
class Request {

  public static function isAjax() {
    if (isset($_SERVER['HTTP_ACCEPT'])) {
      if(strrpos($_SERVER['HTTP_ACCEPT'], 'application/javascript') !== false) {
        header("Content-Type: application/javascript");
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

}
