<?php
    require_once'../config.php';

    if(isset($_SESSION[$uniqueCode])){
        $queryUser = $handler->prepare('SELECT * FROM users WHERE username = :username');
        $queryUser->execute([
            ':username' => $_SESSION[$uniqueCode]
        ]);

        $fetchUser = $queryUser->fetch(PDO::FETCH_ASSOC);

        $queryPermissions = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetchUser['rank']);
        $fetchPermissions = $queryPermissions->fetch(PDO::FETCH_ASSOC);

        if($fetchUser['rank'] == 0){
            header('Location: ../index.php');
        }
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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

  </head>
  <body>

      <div class="container-fluid">
        <?php
            if(isset($_SESSION[$uniqueCode])){
                if($fetchUser['rank'] >= 990){
        ?>
      	<div class="row">
      		<div class="col-md-12">
                <h1>GoatBB Control Panel</h1>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-md-12">
                <hr />
      		</div>
      	</div>
      	<div class="row">

      		<div class="col-md-2">
                <h2>Menu</h2>
                <hr />
                <div class="tabbable tabs-left">
                  <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#1" data-toggle="tab">Home</a></li>
                    <li><a href="#2" data-toggle="tab">Manage categories</a></li>
                    <li><a href="#3" data-toggle="tab">Manage sections</a></li>
                    <li><a href="#4" data-toggle="tab">Manage users</a></li>
                    <li><a href="#5" data-toggle="tab">Search users</a></li>
                    <li><a href="#6" data-toggle="tab">Manage warnings</a></li>
                  </ul>
                </div>
      		</div>
      		<div class="col-md-10">
                <h2>Content</h2>
                <hr />
                <div class="tab-content">
                 <div class="tab-pane active" id="1"><?php require_once'include/home.php'; ?></div>
                 <div class="tab-pane" id="2"><?php require_once'include/categories/categories.php'; ?></div>
                 <div class="tab-pane" id="3"><?php require_once'include/sections/sections.php'; ?></div>
                 <div class="tab-pane" id="4"><?php require_once'include/users/manage.php'; ?></div>
                 <div class="tab-pane" id="5"><?php require_once'include/users/usersearch.php'; ?></div>
                 <div class="tab-pane" id="6"><?php require_once'include/warnings.php'; ?></div>
                </div>
      		</div>
      	</div>
        <?php
            require_once'../include/footer.php';
                }
                else{
                    echo $pagedoesnotexist;
                }
            }
            else{
                echo $pagedoesnotexist;
            }
        ?>
      </div>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/scripts.js"></script>
  </body>
</html>
