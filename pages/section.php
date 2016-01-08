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
                <td style="width: 5%;">Posts</td>
                <td style="width: 15%;">Latest post</td>
            </tr>
            <?php
                $query = $handler->query('SELECT th.*, count(po.t_id) as aantal, max(po.postdate) as lastdate FROM thread th INNER JOIN threadpost po on th.t_id = po.t_id group by po.t_id ORDER BY lastdate DESC');

                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $rcount = $handler->query('SELECT COUNT(*) FROM threadpost WHERE t_id = ' . $fetch['t_id']);
                    $queryTime = $handler->query('SELECT * FROM threadpost WHERE t_id =' . $fetch['t_id'] . ' ORDER BY postdate DESC');

                    $fetchTime = $queryTime->fetch(PDO::FETCH_ASSOC);
                    $rfetch = $rcount->fetch(PDO::FETCH_NUM);
            ?>
            <tr>
                <td><a href="<?php echo $website_url . 'thread/' . $fetch['t_id']; ?>" style="font-weight: bold;"><?php echo $fetch['title']; ?></a></td>
                <td><?php echo $rfetch[0]; ?></td>
                <td>
                    <?php
                        $monthNum  = substr($fetch['postdate'], 5, 2);
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        echo $fetch['title'] . '<br />';
                        echo substr($fetch['lastdate'], 11, 8) . ' on ' . substr($fetch['lastdate'], 8, 2) . ' ' . $dateObj->format('F') . ' ' . substr($fetch['lastdate'], 0, 4) . '<br />';
                        echo'by ' . $fetch['u_id'];
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
