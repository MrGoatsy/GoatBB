<?php
    if(isset($_GET['thread'])){
        $query = $handler->prepare('SELECT * FROM thread WHERE t_id = :t_id');
        $query->execute([
            ':t_id' => $_GET['thread']
        ]);

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount() && $fetch['archived'] == 0){
            $querySignature = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
            $fetchSignature = $querySignature->fetch(PDO::FETCH_ASSOC);

            if(isset($_GET['archive'])){
                perry('UPDATE thread SET archived = 1 WHERE t_id = :t_id', [':t_id' => $_GET['thread']], false);
                perry('UPDATE threadpost SET archived = 1 WHERE t_id = :t_id', [':t_id' => $_GET['thread']], false);
                echo'
                    <div class="alert alert-success fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      The thread has been deleted
                    </div>';
            }
            else{
                $queryU = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
                $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetch['u_id']);
                $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetch['u_id']);

                $fetchr = $queryU->fetch(PDO::FETCH_ASSOC);
                $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
                $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);

                $pagenumber = ((isset($_GET['pn']) && is_numeric($_GET['pn']) && $_GET['pn'] > 0)? (int)$_GET['pn'] : 1);
                $start = (($pagenumber > 1)? ($pagenumber * $perpage) - $perpage : 0);

                $querypage = $handler->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM threadpost WHERE t_id = :t_id LIMIT {$start}, {$perpage}");
                $querypage->execute([
                    ':t_id' => $_GET['thread']
                ]);

                $total = $handler->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
                $pages = ceil($total / $perpage);

                if($pagenumber == 1){
                    $pages = 1;
                }
                elseif($pagenumber > $pages){
                    header('Location: ?pn=1');
                }
    ?>
    <div class="table-responsive">
        <ul class="pagination pull-right">
            <?php
                $i = 1;
                echo'<li><a href="?pn=1">&lt;&lt;</a></li>';
                echo'<li><a href="?pn=' . ($pagenumber - 1) . '">&lt;</a></li>';

                while($i <= $pages){
                    if(!($pagenumber <= $i-5) && !($pagenumber >= $i+5)){
            ?>
                <li <?php echo (($pagenumber === $i)? 'class="active"' : ''); ?>><a href="?pn=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php
                    }
                    $i++;
                }

                echo'<li><a href="?pn=' . ($pagenumber + 1) . '">&gt;</a></li>';
                echo'<li><a href="?pn=' . $pages . '">&gt;&gt;</a></li>';
            ?>
        </ul>
        <table class="table" border=1>
            <tr>
                <td><strong><?php echo $fetch['title']; ?></strong></td>
            </tr>
        </table>
        <?php
            if($pagenumber == 1){
        ?>
        <table class="table" border=1>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td class="threadtd" style="width: 64px;"><img src="<?php echo $website_url . 'images/avatars/' . $fetchr['avatar']; ?>" alt="" class="avatar" /></td>
                            <td class="threadtd"><a href="<?php echo $website_url . 'p/profile?userid=' . $fetchr['u_id']; ?>"><?php echo $fetchr['username']; ?></a></td>
                            <td class="threadtd pull-right">
                                Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                Joined: <?php echo substr($fetchr['joindate'], 5, 2) . '-' . substr($fetchr['joindate'], 0, 4); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        echo $fetch['content'];

                        if(!empty($fetchSignature['signature'])){
                            echo'<hr />';
                            echo $fetchSignature['signature'];
                        }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="" class="btn btn-primary pull-right">Report</a>
                    <?php
                        if($fetchUser['rank'] > 900){
                            echo'<a href="' . $website_url . 'thread/' . $_GET['thread'] . '?archive" class="btn btn-danger pull-right">Delete</a>';
                        }
                    ?>
                </td>
            </tr>
        </table>
        <?php
            }

            $query = $handler->prepare('SELECT * FROM threadpost WHERE t_id = :t_id');
            $query->execute([
                ':t_id' => $_GET['thread']
            ]);

            while($fetch = $querypage->fetch(PDO::FETCH_ASSOC)){
                $queryU = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
                $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetch['u_id']);
                $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetch['u_id']);
                $querySignature = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
                $fetchSignature = $querySignature->fetch(PDO::FETCH_ASSOC);
                $uFetch = $queryU->fetch(PDO::FETCH_ASSOC);
                $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
                $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);
        ?>
        <table class="table" border=1>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td class="threadtd" style="width: 64px;"><img src="<?php echo $website_url . 'images/avatars/' . $uFetch['avatar']; ?>" alt="" class="avatar" /></td>
                            <td class="threadtd"><a href="<?php echo $website_url . 'p/profile?userid=' . $uFetch['u_id']; ?>"><?php echo $uFetch['username']; ?></a></td>
                            <td class="threadtd pull-right">
                                Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                Joined: <?php echo substr($uFetch['joindate'], 5, 2) . '-' . substr($uFetch['joindate'], 0, 4); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        echo $fetch['content'];

                        if(!empty($fetchSignature['signature'])){
                            echo'<hr />';
                            echo $fetchSignature['signature'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td><a href="" class="btn btn-primary pull-right">Report</a></td>
            </tr>
        </table>
            <?php
                }
                if(isset($_SESSION['user'])){
            ?>
            <form method="post">
                <textarea name="threadpost" id="threadpost"></textarea>
                <script>
                    $('#threadpost').summernote({
                        height: 150,
                        // toolbar
                        toolbar: [
                          ['style', ['style']],
                          ['font', ['bold', 'italic', 'underline', 'clear']],
                          // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                          ['fontname', ['fontname']],
                          ['fontsize', ['fontsize']],
                          ['color', ['color']],
                          ['para', ['ul', 'ol', 'paragraph']],
                          ['table', ['table']],
                          ['insert', ['link', 'picture', 'hr']],
                          ['view', ['fullscreen']],   // remove codeview button
                          ['help', ['help']]
                        ]
                    });
                </script>
                <div class="input-group pull-right" style="margin-bottom: 5px;">
                    <input class="btn btn-success" type="submit" name="postToThread" value="Submit" />
                </div>
            </form>
        </div>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['postToThread'])){
            if(!isset($_COOKIE['send'])){
                if(!empty($_POST['threadpost'])){
                    $threadpost = $_POST['threadpost'];
                    $threadpost = $purifier->purify($threadpost);
                    //$thread = strip_tags($thread, '<h1><h2><h3><h4><h5><h6><pre><blockquote><p><b><i><u><font><span><ul><li><table><tr><td><a><img><hr><br>');

                    if(strlen($threadpost)){
                        setcookie('send', 'wait', time()+$waitTime);

                        echo perry('INSERT INTO threadpost (t_id, u_id, content) VALUES (:t_id, :u_id, :content)', [':t_id'=> $_GET['thread'], ':u_id' => $fetchUser['u_id'], ':content' => $threadpost]);

                        header('Location:' . $website_url . 'thread/' . $_GET['thread']);
                    }
                    else{
                        echo $messageTooShort;
                    }
                }
                else{
                    echo $emptyerror;
                }
            }
            else{
                echo'
                    <div class="alert alert-danger fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      ' . $pleaseWait . '
                    </div>';
            }
        }
    }
    }
?>
    </div>
    <?php
        }
    }
        else{
            echo $threaddoesnotexist;
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
