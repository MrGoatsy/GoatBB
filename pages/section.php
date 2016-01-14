<?php
    if(isset($_GET['section'])){
        $query = $handler->prepare('SELECT * FROM section WHERE secname = :secname');
        $query->execute([
            ':secname' => $_GET['section']
        ]);

        $fetchSections = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()){
    ?>
    <div class="table-responsive">
        <?php echo ((isset($_SESSION['user'])? '<a href="' . $website_url . 'p/newthread?s=' . $fetchSections['sc_id'] . '" class="btn btn-primary pull-right">New thread</a><br /><br />' : '')); ?>
        <table class="table" border=1>
            <tr>
                <td>Forum</td>
                <td style="width: 5%;">Replies</td>
                <td style="width: 15%;">Latest post</td>
            </tr>
            <?php
                $query = $handler->query('SELECT th.*, count(po.t_id) AS amount, CASE when th.postdate > IFNULL(po.postdate, "0000-01-01 00:00:00") then max(th.postdate) else max(po.postdate) end AS lastdate FROM thread th LEFT OUTER JOIN threadpost po ON th.t_id = po.t_id WHERE th.archived = 0 GROUP BY po.t_id ORDER BY lastdate DESC');

                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $queryUser = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);
                    $queryTime = $handler->query('SELECT * FROM threadpost WHERE t_id =' . $fetch['t_id'] . ' ORDER BY postdate DESC');
            ?>
            <tr>
                <td><a href="<?php echo $website_url . 'thread/' . $fetch['t_id']; ?>" style="font-weight: bold;"><?php echo $fetch['title']; ?></a></td>
                <td><?php echo $fetch['amount']; ?></td>
                <td>
                    <?php
                        $monthNum  = substr($fetch['postdate'], 5, 2);
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        echo'<a href="' . $website_url . 'thread/' . $fetch['t_id'] . '" style="font-weight: bold;">' . $fetch['title'] . '</a>' . '<br />';
                        echo substr($fetch['lastdate'], 11, 8) . ' on ' . substr($fetch['lastdate'], 8, 2) . ' ' . $dateObj->format('F') . ' ' . substr($fetch['lastdate'], 0, 4) . '<br />';
                        echo'by ' . $fetchUser['username'];
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>

        </table>
        <?php echo ((isset($_SESSION['user'])? '<a href="' . $website_url . 'p/newthread?s=' . $fetchSections['sc_id'] . '" class="btn btn-primary pull-right">New thread</a>' : '')); ?>
    </div>
    <?php
        }
        else{
            echo $sectiondoesnotexist;
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
