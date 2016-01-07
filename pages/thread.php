<?php
    if(isset($_GET['thread'])){
        $query = $handler->prepare('SELECT * FROM thread WHERE t_id = :t_id');
        $query->execute([
            ':t_id' => $_GET['thread']
        ]);

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()){
            $queryU = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
            $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetch['u_id']);
            $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetch['u_id']);

            $fetchr = $queryU->fetch(PDO::FETCH_ASSOC);
            $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
            $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);
    ?>
    <div class="table-responsive">
        <table class="table" border=1>
            <tr>
                <td><?php echo $fetch['title']; ?></td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td class="threadtd" style="width: 64px;"><img src="" alt="" class="avatar" /></td>
                            <td class="threadtd"><?php echo $fetchr['username']; ?></td>
                            <td class="threadtd pull-right">
                                Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                Joined: <?php echo substr($fetchr['joindate'], 0, 7); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><?php echo $fetch['content']; ?></td>
            </tr>
            <tr>
                <td><a href="" class="btn btn-primary pull-right">Report</a></td>
            </tr>
        </table>
            <?php
                $query = $handler->prepare('SELECT * FROM threadpost WHERE t_id = :t_id');
                $query->execute([
                    ':t_id' => $_GET['thread']
                ]);

                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $Uquery = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
                    $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetch['u_id']);
                    $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetch['u_id']);

                    $uFetch = $Uquery->fetch(PDO::FETCH_ASSOC);
                    $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
                    $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);
            ?>
        <table class="table" border=1>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td class="threadtd" style="width: 64px;"><img src="" alt="" class="avatar" /></td>
                            <td class="threadtd"><?php echo $uFetch['username']; ?></td>
                            <td class="threadtd pull-right">
                                Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                Joined: <?php echo substr($fetchr['joindate'], 0, 7); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><?php echo $fetch['content']; ?></td>
            </tr>
            <tr>
                <td><a href="" class="btn btn-primary pull-right">Report</a></td>
            </tr>
        </table>
            <?php
                }
            ?>
    </div>
    <?php
        }
        else{
            echo $threaddoesnotexist;
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
