<?php
    $queryMessages = $handler->prepare('SELECT * FROM messages WHERE u_id_sender = :uid AND sender_archived = :archived');
    $queryMessages->execute([':uid' => $fetchUser['u_id'], ':archived' => 0]);
?>
<div class="row">
    <div class="col-md-12">
        <h2>Outbox</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
            echo'<table class="table">
                    <tr>
                        <td style="width: 20%;">Subject</td>
                        <td style="width: 20%;">To</td>
                        <td style="width: 20%;">Date</td>
                        <td style="width: 20%;">Delete</td>
                    </tr>';
            if($queryMessages->rowCount()){
                while($fetchMessages = $queryMessages->fetch(PDO::FETCH_ASSOC)){
                    $getUserQuery = $handler->prepare('SELECT * FROM users WHERE u_id = :uid');
                    $getUserQuery->execute([':uid' => $fetchMessages['u_id_recipient']]);
                    $fetchMessages['to'] = $getUserQuery->fetch(PDO::FETCH_ASSOC)['username'];

                    echo'
                        <tr>
                            <td>' . (($fetchMessages['messageRead'] == 0)? '<strong>' : '') . '<a href="' . $website_url . 'p/messages?mid=' . $fetchMessages['m_id'] . '&viewoutbox">' . $fetchMessages['subject'] . '</a>' . (($fetchMessages['messageRead'] == 0)? '</strong>' : '') . '</td>
                            <td><a href="' . $website_url . 'p/profile?userid=' . $fetchMessages['u_id_sender'] . '">' . $fetchMessages['to'] . '</a></td>
                            <td>' . $fetchMessages['messageDate'] . '</td>
                            <td><a href="' . $website_url . 'p/messages?mid=' . $fetchMessages['m_id'] . '&viewoutbox&delete" class="btn btn-danger">Delete</a></td>
                        </tr>
                    ';
                }
            }
            else{
                echo'<tr><td colspan="3">' . $outboxEmpty . '</td></tr>';
            }
            echo'</table>';
        ?>
    </div>
</div>
