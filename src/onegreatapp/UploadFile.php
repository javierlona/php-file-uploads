<?php
namespace onegreatapp;

class UploadFile {

  protected $destination;
  protected $messages = [];
  protected $maxSize = 51200;

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

  public function set_max_size($bytes) {
    if(is_numeric($bytes) && $bytes > 0) {
      $this->maxSize = $bytes;
    }
  }

  public function upload() {
    // current doesn't need to know the name of a file input field.
    // $uploaded is the array details of the file uploaded
    $uploaded = current($_FILES);
    if($this->check_file($uploaded)) {
      $this->move_file($uploaded);
    }
  }

  public function get_messages() {
    return $this->messages;
  }

  protected function check_file($file) {
    if($file['error'] != 0) {
      $this->get_error_message($file);
      return false;
    }
    if(!$this->check_size($file)) {
      return false;
    }
    return true;
  }

  protected function get_error_message($file) {
    switch($file['error']) {
      case 1:
      case 2:
        $this->messages[] = $file['name'] . ' is too big.';
        break;
      case 3:
        $this->messages[] = $file['name'] . ' was only partially uploaded.';
        break;
      case 4:
        $this->messages[] = 'No file submitted.';
        break;
      default:
        $this->messages[] = 'Sorry, there was a problem uploading ' . $file['name'];
        break;
    }
  }

  protected function check_size($file) {
    if($file['size'] == 0) {
      $this->messages[] = $file['name'] . ' is empty.';
      return false;
    } elseif ($file['size'] > $this->maxSize) {
      $this->messages[] = $file['name'] . ' exceeds the maxium size for a file.';
      return false;
    } else {
      return true;
    }
  }

  protected function move_file($file) {
    // add to messages array
    $this->messages[] = $file['name'] . ' was uploaded successfully.';
  }
}
