<div class="row">
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
                        if(isset($_SESSION[$uniqueCode])){
                            echo'
                            <li>
                                <a href="' . $website_url . 'p/profile?userid=' . $fetchUser['u_id'] . '">Profile</a>
                            </li>
                            <li>
                                <a href="' . $website_url . 'p/messages">Messages</a>
                            </li>
                            ';
                            if($fetchUser['rank'] >= 900){
                                echo'
                                <li>
                                    <a href="' . $website_url . 'admin/">Control panel</a>
                                </li>
                                ';
                            }
                            echo'
                            <li>
                                <a href="' . $website_url . 'p/logout">Log out</a>
                            </li>
                            ';
                        }
                        else{
                            echo'
                            <li>
                                <a href="' . $website_url . 'p/login">Login</a>
                            </li>
                            ';
                        }
                     ?>
                     <form class="navbar-form navbar-right" role="search" method="post" action="<?php echo $website_url; ?>p/search">
                         <div class="form-group">
                             <input type="text" class="form-control" name="searchValue" placeholder="Search" />
                         </div>
                         <input type="submit" class="btn btn-default" name="submitSearch" />
                     </form>
                </ul>
            </div>
        </nav>
    </div>
</div>
