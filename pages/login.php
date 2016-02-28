<?php
    if(isset($_SESSION['goatbbuser'])){
        header('Location: ' . $website_url);
    }
    else{
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <h2>Login</h2><hr />
            <form method="post">
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                  <input class="form-control" type="text" name="username" placeholder="Username" />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                  <input class="form-control" type="password" name="password" placeholder="Password" />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                    <input class="btn btn-success" type="submit" name="login" value="Login" />
                </div>
            </form>
            <div style="margin-right: 5px; float: right;">
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST['login'])){
                            echo login();
                        }
                    }
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <h2>Register</h2><hr />
            <form method="post">
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                  <input class="form-control" type="text" name="username" placeholder="Username" required />
                </div>
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                  <input class="form-control" type="email" name="email" placeholder="Email" required />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                  <input class="form-control" type="password" name="password" placeholder="Password" required />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                  <input class="form-control" type="password" name="passwordconf" placeholder="Repeat password" required />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                    <div style="display: none;">
                  <span class="input-group-addon"><i class="fa fa-at fa-fw"></i></span>
                  <input class="form-control" type="text" name="name" placeholder="Name" />
                    </div>
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                    <input class="btn btn-info" type="submit" name="register" value="Register" />
                </div>
            </form>
            <div style="margin-right: 10px; float: right;">
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST['register'])){
                            echo register();
                        }
                    }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<?php
}
?>
