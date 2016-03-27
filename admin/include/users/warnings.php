<h3>Warnings for UID <?php echo (int)$_GET['uid'] ?></h3>
<?php
    $queryWarningUser = $handler->prepare('SELECT * FROM users WHERE u_id = :uid');
    $queryWarningUser->execute([
        ':uid' => (int)$_GET['uid']
    ]);

    if($queryWarningUser->rowCount()){
        $fetchWarningsUser = $queryWarningUser->fetch(PDO::FETCH_ASSOC);
        $queryWarnings = $handler->query('SELECT * FROM warnings WHERE u_id =' . $fetchWarningsUser['u_id']);

        if($queryWarnings->rowCount()){
            echo'<table class="table">
                    <tr>
                        <td>Warning ID</td>
                        <td>Warning points</td>
                        <td>Reason</td>
                        <td>Date</td>
                        <td>Archive</td>
                    </tr>';
            while($fetchWarnings = $queryWarnings->fetch(PDO::FETCH_ASSOC)){
                echo'
                    <tr>
                        <td>' . $fetchWarnings['w_id'] . '</td>
                        <td>' . $fetchWarnings['amount'] . '</td>
                        <td>' . $fetchWarnings['reason'] . '</td>
                        <td>' . $fetchWarnings['warningDate'] . '</td>
                        <td>' . (($fetchWarnings['archived'] == 0)? '<a href="?uid=' . $fetchWarnings['u_id'] . '&warning=' . $fetchWarnings['w_id'] . '&archive" class="btn btn-warning">Archive</a>' : 'Archived') . '</td>
                    </tr>
                ';
            }
            echo'</table>';
        }
        else{
            echo $noWarningsFound;
        }
    }
    else{
        echo $userDoesNotExist;
    }
?>
