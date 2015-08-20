<?php

class SCMessage {

  private $success = null;
  private $data    = null;
  private $msg     = null;

  public static function create($success, $data, $msg){
    // Clone the empty message
    $scm = clone $this;

    $scm->success = $success;
    $scm->data    = $data;
    $scm->msg     = $msg;

    return $scm;
  }
}
