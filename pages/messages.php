<?php
    if(isset($_SESSION[$uniqueCode])){
?>
<div class="row">
    <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="<?php echo $website_url; ?>p/messages">Inbox</a></li>
          <li><a href="<?php echo $website_url; ?>p/messages?new">New message</a></li>
          <li><a href="<?php echo $website_url; ?>p/messages?outbox">Sent messages</a></li>
        </ul>
    </div>
    <div class="col-md-10">
        <?php
            if(isset($_GET['new'])){
                require_once'messages/new.php';
            }
            elseif(isset($_GET['outbox'])){
                require_once'messages/outbox.php';
            }
            elseif(isset($_GET['mid'])){
                if(isset($_GET['viewinbox'])){
                    require_once'messages/viewinbox.php';
                }
                elseif(isset($_GET['viewoutbox'])){
                    require_once'messages/viewoutbox.php';
                }
            }
            else{
                require_once'messages/inbox.php';
            }
         ?>
    </div>
</div>
<?php
    }
    else{
        echo $pagedoesnotexist;
    }
?>
