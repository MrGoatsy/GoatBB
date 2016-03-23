<?php
    require'config.php';

    if(isset($_SESSION['goatbbuser'])){
        $queryUser = $handler->prepare('SELECT * FROM users WHERE username = :username');
        $queryUser->execute([
            ':username' => $_SESSION['goatbbuser']
        ]);

        $fetchUser = $queryUser->fetch(PDO::FETCH_ASSOC);

        $queryPermissions = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetchUser['rank']);
        $fetchPermissions = $queryPermissions->fetch(PDO::FETCH_ASSOC);

        if($fetchUser['rank'] == 0){
            $banned = 1;
        }
        else{
            $banned = 0;
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
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="<?php echo $website_url; ?>js/jquery.js"></script>
    <script src="<?php echo $website_url; ?>js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.js"></script>
    <link href="<?php echo $website_url; ?>css/main.css?2" rel="stylesheet">

  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <h1>GoatBB</h1>
          </div>
      </div>
    <div class="row">
          <?php
              require'include/menu.php';
           ?>
    </div>
    	<div class="row">
    		<div class="col-md-12">
            <?php
                if($banned === 1){
                    require_once'pages/banned.php';
                }
                else{
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
                    else{
                      include'pages/home.php';
                    }
                }
            ?>
    		</div>
    	</div>
        <?php
            require'include/footer.php';
        ?>
    </div>
    <script src="<?php echo $website_url; ?>js/scripts.js?7"></script>
  </body>
</html>
