<div class="col-md-12">
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button> <a class="navbar-brand" href="#">Brand</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?php echo $website_url; ?>">Home</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(isset($_SESSION['user'])){
                        $query = $handler->prepare('SELECT * FROM users WHERE username = :username');
                        $query->execute([
                            ':username' => $_SESSION['user']
                        ]);
                        $fetch = $query->fetch(PDO::FETCH_ASSOC);

                        if($fetch['rank'] >= 900){
                            echo'
                            <li>
                                <a href="' . $website_url . 'admin/">Control panel</a>
                            </li>
                            ';
                        }
                    }
                    else{
                        echo'
                        <li>
                            <a href="' . $website_url . 'p/login">Login</a>
                        </li>
                        ';
                    }
                 ?>
                 <form class="navbar-form navbar-right" role="search">
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="Search" />
                     </div>
                     <button type="submit" class="btn btn-default">
                         Submit
                     </button>
                 </form>
            </ul>
        </div>

    </nav>
</div>
