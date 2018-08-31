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


  public function upload() {
    // current doesn't need to know the name of a file input field.
    $uploaded = current($_FILES);
    if($this->check_file($uploaded)) {
      $this->move_file($uploaded);
    }
  }

  public function check_file($file) {
    return true;
  }

  protected function move_file($file) {
    echo $file['name'] . ' was uploaded successfully.';
  }
}
