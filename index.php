<?php
  use onegreatapp\UploadFile;

  $max = 5000 * 1024;
  $message = "";

  if(isset($_POST['upload'])) {
    require_once 'src/onegreatapp/UploadFile.php';
    $destination = __DIR__ . '/uploaded/';
    try {
      $upload = new UploadFile($destination);
    } catch (Exception $e) {
      $message = $e->getMessage();
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
            <h1 id="forms">Forms</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="bs-component">
            <?php echo isset($message) ? $message : ''; ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <fieldset>
                <legend>Legend</legend>
                <div class="form-group">
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
                  <label for="exampleInputFile">File input</label> <input aria-describedby=
                  "fileHelp" class="form-control-file" id="filename" type="file" name="filename">
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
