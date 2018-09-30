<?php
// Namespaces define the location of class file. The 'use' statement allows us the ability to create a new object without writing the entire namespace.
use onegreatapp\UploadFile;

// Equivalent to 2MB, file size stated in bytes
$max = 2048 * 1024;

// App messages are stored in result array
$result = [];

if(isset($_POST['upload'])) {
  // Call the Upload Class
  require_once 'src/onegreatapp/UploadFile.php';

  // Set the destination where to save the uploaded files
  $destination = __DIR__ . '/src/onegreatapp/uploaded/';

  try {
    // Instantiate new object
    $upload = new UploadFile($destination);
    $upload->set_max_size($max);
    $upload->upload();
    $result = $upload->get_messages();
  } catch (Exception $e) {
    $result[] = $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="ie=edge" http-equiv="X-UA-Compatible">
  <link rel="stylesheet" href="./css/style.css">
  <!-- <link href="https://bootswatch.com/4/lumen/bootstrap.css" rel="stylesheet"> -->
  <title>PHP File Uploads</title>
</head>
<body>
  <div class="container">
    <h1 id="forms">Upload Files Form</h1>
    <?php if ($result) { ?>
    <ul class="list-group">
    <?php  foreach ($result as $message) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$message</li>";
    }?>
    </ul>
    <?php } ?>  
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <fieldset>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
          <input aria-describedby=
          "fileHelp" class="form-control-file" id="filename" type="file" name="filename[]" multiple>
          <small class="form-text text-muted" id="fileHelp">Only .png, .jpg, and .jpeg files allowed.</small>
        <button class="btn btn-primary" type="submit" name="upload">Upload File</button>
      </fieldset>
    </form>

  <div class="container">
    <div class="main-img">
      <img id="current" src="./src/onegreatapp/uploaded/img1.jpeg" alt="">
    </div>
    
    <div class="imgs">
      <img src="./src/onegreatapp/uploaded/img1.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img2.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img3.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img4.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img5.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img6.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img7.jpeg" alt="">
      <img src="./src/onegreatapp/uploaded/img8.jpeg" alt="">
  </div>



  <div class="container">
    <?php 
      // Set the destination where to save the uploaded files
      // $destination = __DIR__ . '/src/onegreatapp/uploaded/';
      // $dir = new DirectoryIterator($destination);
      // foreach ($dir as $fileinfo) {
      //   if (!$fileinfo->isDot()) { 
          ?>
        <!-- <img src="<?php //echo './src/onegreatapp/uploaded/' . $fileinfo->getFilename(); ?>" alt=""> -->
        
    <?php
      //   }
      // }
    ?>
  </div>
</body>
</html>
