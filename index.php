<?php
  use onegreatapp\UploadFile;

  $max = 2048 * 1024;
  $result = [];

  if(isset($_POST['upload'])) {
    require_once 'src/onegreatapp/UploadFile.php';
    $destination = __DIR__ . '/uploaded/';
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
  <link href="https://bootswatch.com/4/lumen/bootstrap.css" rel="stylesheet">
  <title>PHP File Uploads</title>
</head>
<body>
  <div class="container">
    <!-- Forms
          ================================================== -->
    <div class="bs-docs-section">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-header">
            <h1 id="forms">Upload Form</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ($result) { ?>
        <ul class="list-group">
        <?php  foreach ($result as $message) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$message</li>";
        }?>
        </ul>
        <?php } ?>
        <div class="col-lg-6">
          <div class="bs-component">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <fieldset>
                <!-- <legend>Legend</legend> -->
                <div class="form-group">
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
                  <label for="exampleInputFile">File input</label> <input aria-describedby=
                  "fileHelp" class="form-control-file" id="filename" type="file" name="filename[]" multiple>
                  <small class="form-text text-muted" id="fileHelp">This is some placeholder
                  block-level help text for the above input. It's a bit lighter and easily wraps to
                  a new line.</small>
                </div><button class="btn btn-primary" type="submit" name="upload">Upload File</button>
              </fieldset>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
