<?php
    if(isset($_GET['section'])){
        $query = $handler->prepare('SELECT * FROM section WHERE secname = :secname');
        $query->execute([
            ':secname' => $_GET['section']
        ]);

        $fetchSections = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()){
            $pagenumber = ((isset($_GET['pn']) && is_numeric($_GET['pn']) && $_GET['pn'] > 0)? (int)$_GET['pn'] : 1);
            $start = (($pagenumber > 1)? ($pagenumber * $perpage) - $perpage : 0);

            $querypage = $handler->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM thread WHERE sc_id = :sc_id LIMIT {$start}, {$perpage}");
            $querypage->execute([
                ':sc_id' => $_GET['section']
            ]);

            $query = $handler->query('SELECT SQL_CALC_FOUND_ROWS th.*, count(po.t_id) AS amount, CASE when th.postdate > IFNULL(po.postdate, "0000-01-01 00:00:00") then max(th.postdate) else max(po.postdate) end AS lastdate FROM thread th LEFT OUTER JOIN threadpost po ON th.t_id = po.t_id WHERE th.archived = 0 AND th.sc_id = ' . $fetchSections['sc_id'] . ' GROUP BY th.t_id ORDER BY lastdate DESC LIMIT ' . $start . ', ' . $perpage);

            $total = $handler->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
            $pages = ceil($total / $perpage);

            if($pagenumber == 1){
                $pages = (($pages > 1)? $pages : 1);
            }
            elseif($pagenumber > $pages){
                header('Location: ?pn=1');
            }
    ?>
    <div class="table-responsive">
        <?php
            echo sectionPagination();
         ?>
        <table class="table" border=1>
            <tr>
                <td>Forum</td>
                <td style="width: 5%;">Replies</td>
                <td style="width: 15%;">Latest post</td>
            </tr>
            <?php
                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $queryUser = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id']);

                    $fetchPostedBy = $queryUser->fetch(PDO::FETCH_ASSOC);
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
                        echo'by ' . $fetchPostedBy['username'];
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>

        </table>
        <?php
            echo sectionPagination();
         ?>
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
