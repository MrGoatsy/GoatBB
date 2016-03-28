<?php
    echo'<h2>Inbox</h2>';
    $queryMessages = $handler->prepare('SELECT * FROM messages WHERE m_id = :mid AND u_id_recipient = :uid');
    $queryMessages->execute([':mid' => (int)$_GET['mid'], ':uid' => $fetchUser['u_id']]);

    if($queryMessages->rowCount()){
        $fetchMessage = $queryMessages->fetch(PDO::FETCH_ASSOC);

        $getUserQuery = $handler->prepare('SELECT * FROM users WHERE u_id = :uid');
        $getUserQuery->execute([':uid' => $fetchMessage['u_id_sender']]);
        $fetchSender = $getUserQuery->fetch(PDO::FETCH_ASSOC);

        $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetchSender['u_id']);
        $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetchSender['u_id']);

        $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
        $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);

        if($fetchUser['u_id'] == $fetchMessage['u_id_recipient']){
            perry('UPDATE messages SET messageRead = :messageRead WHERE m_id = :mid', [':messageRead' => 1, ':mid' => (int)$_GET['mid']]);

            $queryRank = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetchSender['rank']);
            $fetchRank = $queryRank->fetch(PDO::FETCH_ASSOC);
?>
            <table class="table" border=1>
                <tr>
                    <td><strong><?php echo $fetchMessage['subject']; ?></strong></td>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td class="threadtd" style="width: 64px;"><img src="<?php echo $website_url . 'images/avatars/' . $fetchSender['avatar']; ?>" alt="" class="avatar" /></td>
                                <td class="threadtd"><a href="<?php echo $website_url . 'p/profile?userid=' . $fetchSender['u_id']; ?>"><?php echo $fetchSender['username']; ?></a><br />
                                <?php echo $fetchRank['rankName']; ?></td>
                                <td class="threadtd pull-right">
                                    Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                    Joined: <?php echo substr($fetchSender['joindate'], 5, 2) . '-' . substr($fetchSender['joindate'], 0, 4); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                            echo $fetchMessage['content'];

                            if(!empty($fetchSender['signature'])){
                                echo'<hr />';
                                echo $fetchSender['signature'];
                            }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo'<a href="' . $website_url . 'p/messages?mid=' . $fetchMessage['m_id'] . '&viewinbox&delete" class="btn btn-danger pull-right">Delete</a>'; ?>
                        <a href="" class="btn btn-primary pull-right">Report</a>
                    </td>
                </tr>
            </table>
            <form method="post">
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                  <input class="form-control" type="text" name="subject" value="<?php echo $fetchMessage['subject']; ?>" placeholder="Subject" />
                </div>
                <textarea name="messageReply" id="messageReply"></textarea>
                <script>
                    $('#messageReply').summernote({
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
                    <input class="btn btn-success" type="submit" name="postMessage" value="Submit" />
                </div>
            </form>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['postMessage'])){
                    $checkMessage = $handler->query('SELECT * FROM messages WHERE u_id_sender =' . $fetchUser['u_id'] . ' ORDER BY messageDate DESC LIMIT 1');
                    $fetchMessageDate = $checkMessage->fetch(PDO::FETCH_ASSOC);
                    $postDate = strtotime($fetchMessageDate['messageDate']);
                    $currentDate = strtotime(date("Y-m-d H:i:s"));

                    if($currentDate - $postDate >= $fetchPermissions['postTime']){
                        if(!empty($_POST['messageReply'])){
                            $subject = htmlentities($_POST['subject'], ENT_QUOTES);
                            $messageReply = $_POST['messageReply'];
                            $messageReply = $purifier->purify($messageReply);

                            if(strlen($messageReply)){
                                echo perry('INSERT INTO messages (u_id_sender, u_id_recipient, subject, content, messageDate)
                                VALUES (:uidsender, :uidrecipient, :subject, :content, :messagedate)',
                                [':uidsender'=> $fetchUser['u_id'],':uidrecipient' => $fetchSender['u_id'], ':subject' => $subject, ':content' => $messageReply, ':messagedate' => date("Y-m-d H:i:s")]);

                                header("Refresh:0;url={$website_url}p/messages");
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
            if(isset($_GET['delete'])){
                perry('UPDATE messages SET recipient_archived = :archived WHERE m_id = :mid', [':archived' => 1, ':mid' => $fetchMessage['m_id']]);

                header("Refresh:0;url={$website_url}p/messages");
            }
        }
        else{
            echo $messageDoesNotExist;
        }
    }
    else{
        echo $messageDoesNotExist;
    }
?>
