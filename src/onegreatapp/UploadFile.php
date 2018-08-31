<?php
namespace onegreatapp;

class UploadFile {

  protected $destination;

  public function __construct($uploadFolder) {
    if(!is_dir($uploadFolder) || !is_writeable($uploadFolder)) {
      throw new \Exception("$uploadFolder must be a valid, writable folder.");
    }
    // Add a trailing slash
    if($uploadFolder[strlen($uploadFolder)-1] != '/') {
      $uploadFolder .= '/';
    }
    $this->destination = $uploadFolder;
  }
}
