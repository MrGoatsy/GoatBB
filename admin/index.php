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

    <link href="<?php echo $website_url; ?>admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $website_url; ?>admin/css/theme.min.css" rel="stylesheet">
    <link href="<?php echo $website_url; ?>admin/css/main.css?2" rel="stylesheet">
    <script src="<?php echo $website_url; ?>admin/js/chart.min.js"></script>

  </head>
  <body class="site">
        <?php
            if(isset($_SESSION[$uniqueCode])){
                if($fetchUser['rank'] >= 990){
        ?>
        <header>
            <div class="container-fluid">
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
            </div>
        </header>
        <main class="site-content">
            <div class="container-fluid">
              	<div class="row">
              		<div class="col-md-12">
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#1" data-toggle="tab">Home</a></li>
                                <li><a href="#2" data-toggle="tab">Manage categories</a></li>
                                <li><a href="#3" data-toggle="tab">Manage sections</a></li>
                                <li><a href="#4" data-toggle="tab">Manage users</a></li>
                                <li><a href="#5" data-toggle="tab">Search users</a></li>
                                <li><a href="#6" data-toggle="tab">Manage reports</a></li>
                            </ul>
                        </div><br />
              		</div>
                </div>
                <div class="row">
              		<div class="col-md-12">
                        <div class="tab-content">
                         <div class="tab-pane active" id="1"><?php require_once'include/home.php'; ?></div>
                         <div class="tab-pane" id="2"><?php require_once'include/categories/categories.php'; ?></div>
                         <div class="tab-pane" id="3"><?php require_once'include/sections/sections.php'; ?></div>
                         <div class="tab-pane" id="4"><?php require_once'include/users/manage.php'; ?></div>
                         <div class="tab-pane" id="5"><?php require_once'include/users/usersearch.php'; ?></div>
                         <div class="tab-pane" id="6"><?php require_once'include/reports/reportoverview.php'; ?></div>
                        </div>
              		</div>
              	</div>
            </div>
        </main>
        <footer>
            <div class="container-fluid">
                <?php
                    require_once'../include/footer.php';
                ?>
            </div>
        </footer>
        <?php
                }
                else{
                    echo $pagedoesnotexist;
                }
            }
            else{
                echo $pagedoesnotexist;
            }
        ?>
      <script src="<?php echo $website_url; ?>admin/js/jquery.min.js"></script>
      <script src="<?php echo $website_url; ?>admin/js/bootstrap.min.js"></script>
      <script src="<?php echo $website_url; ?>admin/js/scripts.js"></script>
  </body>
</html>
