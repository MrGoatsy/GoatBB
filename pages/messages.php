<div class="row">
    <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="<?php echo $website_url; ?>p/messages">Inbox</a></li>
          <li><a href="<?php echo $website_url; ?>p/messages?new">New message</a></li>
          <li><a href="<?php echo $website_url; ?>p/messages?sent">Sent messages</a></li>
        </ul>
    </div>
    <div class="col-md-10">
        <?php
            if(isset($_SESSION['goatbbuser'])){
                if(isset($_GET['new'])){
                    require_once'messages/new.php';
                }
                elseif(isset($_GET['outbox'])){
                    require_once'messages/outbox.php';
                }
                elseif(isset($_GET['mid'])){
                    echo'<h2>Inbox</h2>';
                    $queryMessages = $handler->prepare('SELECT * FROM messages WHERE m_id = :mid AND u_id_recipient = :uid');
                    $queryMessages->execute(['mid' => (int)$_GET['mid'], ':uid' => $fetchUser['u_id']]);

                    if($queryMessages->rowCount()){
                        $fetchMessageCheck = $queryMessages->fetch(PDO::FETCH_ASSOC);

                        if($fetchUser['u_id'] == $fetchMessageCheck['u_id_recipient']){

                        }
                    }
                    else{
                        echo $messageDoesNotExist;
                    }
                }
                else{
                    require_once'messages/inbox.php';
                }
            }
         ?>
    </div>
</div>
