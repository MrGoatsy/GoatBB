<?php
    if(isset($_GET['section'])){
        $query = $handler->prepare('SELECT * FROM section WHERE secname = :secname');
        $query->execute([
            ':secname' => $_GET['section']
        ]);

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()){
    ?>
    <div class="table-responsive">
        <?php echo ((isset($_SESSION['user'])? '<a href="' . $website_url . 'p/newthread?s=' . $fetch['sc_id'] . '" class="btn btn-primary pull-right">New thread</a><br /><br />' : '')); ?>
        <table class="table" border=1>
            <tr>
                <td>Forum</td>
                <td style="width: 5%;">Posts</td>
                <td style="width: 15%;">Latest post</td>
            </tr>
    <?php
        $query = $handler->query('SELECT * FROM thread ORDER BY postdate DESC');

        while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
            $rcount = $handler->query('SELECT COUNT(*) FROM threadpost WHERE t_id = ' . $fetch['t_id']);
            $queryTime = $handler->query('SELECT * FROM threadpost WHERE t_id =' . $fetch['t_id'] . ' ORDER BY postdate DESC');

            $fetchTime = $queryTime->fetch(PDO::FETCH_ASSOC);
            $rfetch = $rcount->fetch(PDO::FETCH_NUM);

            if(strtotime($fetch['postdate']) < strtotime($fetchTime['postdate'])){
                $fetch['postdate'] = $fetchTime['postdate'];
                $fetch['u_id'] = $fetchTime['u_id'];
            }
    ?>
    <tr>
        <td><a href="<?php echo $website_url . 'thread/' . $fetch['t_id']; ?>" style="font-weight: bold;"><?php echo $fetch['title']; ?></a></td>
        <td><?php echo $rfetch[0]; ?></td>
        <td>
            <?php
                $monthNum  = substr($fetch['postdate'], 5, 2);
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                echo $fetch['title'] . '<br />';
                echo substr($fetch['postdate'], 11, 8) . ' on ' . substr($fetch['postdate'], 8, 2) . ' ' . $dateObj->format('F') . ' ' . substr($fetch['postdate'], 0, 4) . '<br />';
                echo'by ' . $fetch['u_id'];
            ?>
        </td>
    </tr>
    <?php
        }
    ?>
        </table>
        <?php echo ((isset($_SESSION['user'])? '<a href="' . $website_url . 'p/newthread?s=' . $fetch['sc_id'] . '" class="btn btn-primary pull-right">New thread</a>' : '')); ?>
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
