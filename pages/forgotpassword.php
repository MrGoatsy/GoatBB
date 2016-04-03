<div class="row">
    <div class="col-md-4">
        <?php
            if(isset($_SESSION[$uniqueCode])){
                header('Location: ' . $website_url);
            }
            else{
        ?>
            <h2>Forgot password</h2><hr />
            <form method="post">
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                  <input class="form-control" type="email" name="email" placeholder="email" />
                </div>
                <div class="input-group" style="margin-bottom: 5px;">
                    <input class="btn btn-success" type="submit" name="forgotPasswordSubmit" value="Submit" />
                </div>
            </form>
            <div style="margin-right: 5px; float: right;">
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST['forgotPasswordSubmit'])){
                            echo forgotpassword();
                        }
                    }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
