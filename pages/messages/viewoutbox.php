<?php
    echo'<h2>Inbox</h2>';
    $queryMessages = $handler->prepare('SELECT * FROM messages WHERE m_id = :mid AND u_id_sender = :uid');
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

        if($fetchUser['u_id'] == $fetchMessage['u_id_sender']){
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
                        <?php echo'<a href="' . $website_url . 'p/messages?mid=' . $fetchMessage['m_id'] . '&viewoutbox&delete" class="btn btn-danger pull-right">Delete</a>'; ?>
                    </td>
                </tr>
            </table>
<?php
            if(isset($_GET['delete'])){
                perry('UPDATE messages SET sender_archived = :archived WHERE m_id = :mid', [':archived' => 1, ':mid' => $fetchMessage['m_id']]);

                header("Refresh:0;url={$website_url}p/messages?outbox");
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
