<?php
    $queryMessages = $handler->prepare('SELECT * FROM messages WHERE u_id_recipient = :uid');
    $queryMessages->execute([':uid' => $fetchUser['u_id']]);
?>
<div class="row">
    <div class="col-md-12">
        <h2>Inbox</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
            if($queryMessages->rowCount()){
                echo'<table class="table">
                        <tr>
                            <td>Subject</td>
                            <td>From</td>
                            <td>Date</td>
                        </tr>';
                while($fetchMessages = $queryMessages->fetch(PDO::FETCH_ASSOC)){
                    $getUserQuery = $handler->prepare('SELECT * FROM users WHERE u_id = :uid');
                    $getUserQuery->execute([':uid' => $fetchMessages['u_id_sender']]);
                    $fetchMessages['from'] = $getUserQuery->fetch(PDO::FETCH_ASSOC)['username'];

                    echo'
                        <tr>
                            <td><a href="' . $website_url . 'p/messages?mid=' . $fetchMessages['m_id'] . '">' . $fetchMessages['subject'] . '</a></td>
                            <td>' . $fetchMessages['from'] . '</td>
                            <td>' . $fetchMessages['messageDate'] . '</td>
                        </tr>
                    ';
                }
                echo'</table>';
            }
            else{
                echo $inboxEmpty;
            }
        ?>
    </div>
</div>
