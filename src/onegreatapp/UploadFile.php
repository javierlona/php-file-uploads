<?php
namespace onegreatapp;

class UploadFile {

  protected $destination;
  protected $messages = [];
  protected $maxSize = 51200;
  protected $permittedTypes = ['image/jpeg', 'image/png'];
  protected $newFileName;

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
    // we can get the value of upload max file size, using the built-in PHP function, in ini_get.
    $serverMax = self::convert_to_bytes(ini_get('upload_max_filesize'));
    // Throws an error if web developer sets the max size in index.php higher than server limit
    if($bytes > $serverMax) {
      throw new \Exception('Maximum size cannot exceed server limit for individual files: ' . self::convert_from_bytes($serverMax));
    }
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

  public static function convert_to_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    if(in_array($last, ['g', 'm', 'k'])) {
      // Explicit cast to number removes the "M, K, or G"
      $val = (float) $val;
      switch ($last) {
          case 'g':
              $val *= 1024;
          case 'm':
              $val *= 1024;
          case 'k':
              $val *= 1024;
      }
    }
    return $val;
  }

  public static function convert_from_bytes($bytes) {
    $bytes /= 1024;
    if($bytes > 1024) {
        return number_format($bytes/1024, 1) . ' MB';
    } else {
        return number_format($bytes, 1) . ' KB';
    }
  }

  protected function check_file($file) {
    if($file['error'] != 0) {
      $this->get_error_message($file);
      return false;
    }
    if(!$this->check_size($file)) {
      return false;
    }
    if(!$this->check_type($file)) {
      return false;
    }
    $this->check_name($file);
    return true;
  }

  protected function get_error_message($file) {
    switch($file['error']) {
      case 1:
      case 2:
      $this->messages[] = $file['name'] . ' is too big: (max: ' .
      self::convert_from_bytes($this->maxSize) . ').';
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
      $this->messages[] = $file['name'] . ' exceeds the maxium size for a file.' . self::convert_from_bytes($this->maxsize) . ')';
      return false;
    } else {
      return true;
    }
  }

  protected function check_type($file) {
    if(in_array($file['type'], $this->permittedTypes)) {
      return true;
    } else {
      $this->messages[] = $file['name'] . ' is not permitted type of file.';
      return false;
    }
  }

  protected function check_name($file) {
    // eventually be capable of handling multiple file uploads.
    // So, newName needs to be cleared each time this method is used.
    $this->newFileName = null;
    $noSpacesFileName = str_replace(' ', '_', $file['name']);
    if($noSpacesFileName != $file['name']) {
      $this->newFileName = $noSpacesFileName;
    }
  }

  protected function move_file($file) {
    // Determine if the file has been renamed
    $filename = isset($this->newFileName) ? $this->newFileName : $file['name'];
    $success = move_uploaded_file($file['tmp_name'], $this->destination . $filename);
    if($success) {
      // add to messages array
      $result = $file['name'] . ' was uploaded successfully';
      if(!is_null($this->newFileName)) {
        $result .= ', and was renamed ' . $this->newFileName;
      }
      $result .= '.';
      $this->messages[] = $result;
    } else {
      // Use the original filename
      $this->messages[] = 'Could not upload ' . $file['name'];
    }
  }
}
