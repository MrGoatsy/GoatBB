<?php
    require'config.php';

    if(isset($_SESSION['user'])){
        $queryUser = $handler->prepare('SELECT * FROM users WHERE username = :username');
        $queryUser->execute([
            ':username' => $_SESSION['user']
        ]);

        $fetchUser = $queryUser->fetch(PDO::FETCH_ASSOC);

        if($fetchUser['banned'] == 1){
            $banned = 1;
        }
    }
    else{
        $fetchUser = NULL;
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GoatBB</title>

    <meta name="author" content="Tom Heek">

    <link href="<?php echo $website_url; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $website_url; ?>css/custom.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    <link href="<?php echo $website_url; ?>dist/summernote.css" rel="stylesheet">
    <script src="<?php echo $website_url; ?>dist/summernote.js"></script>
    <script src="<?php echo $website_url; ?>js/script.js"></script>
    <link href="<?php echo $website_url; ?>css/main.css" rel="stylesheet">

  </head>
  <body>

          <div class="container-fluid">
              <?php
                  require'include/title.php';
                  require'include/menu.php';
               ?>
          	<div class="row">
          		<div class="col-md-12">
                      <div class="row">
                          <?php
                              if(isset($_GET['p'])){
                                  if(file_exists('pages/' . $_GET['p'] . '.php')){
                                      include'pages/' . $_GET['p'] . '.php';
                                  }
                                  else{
                                      echo $pagedoesnotexist;
                                  }
                              }
                              elseif(isset($_GET['section'])){
                                  require_once'pages/section.php';
                              }
                              elseif(isset($_GET['thread'])){
                                  require_once'pages/thread.php';
                              }
                              elseif($banned === 1){
                                  require_once'pages/banned.php';
                              }
                              else{
                                  include'pages/home.php';
                              }
                           ?>
                      </div>
          		</div>
          	</div>
              <?php
                  require'include/footer.php';
               ?>
          </div>
  </body>
</html>
