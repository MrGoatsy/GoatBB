<div class="col-md-12">
    <div class="tabbable" id="tabs-618721">
        <ul class="nav nav-tabs">
            <?php
                $query = $handler->query('SELECT * FROM category');
                $x = 0;
                $cId = '';

                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
            ?>
            <li <?php echo (($x == 0)? 'class="active"' : ''); ?>>
                <a href="#panel-<?php echo $fetch['c_id']; ?>" data-toggle="tab"><?php echo $fetch['categoryname']; ?></a>
            </li>
            <?php
                    $cId .= $fetch['c_id'] . ', ';
                    $x++;
                }
            ?>
        </ul><br />
        <div class="tab-content">
            <?php
                $pieces = explode(', ', $cId);
                array_pop($pieces);
                $x = 0;

                foreach($pieces as $dat){
                    $query = $handler->query('SELECT * FROM section WHERE c_id = ' . $dat . ' ORDER BY sorder ASC');
            ?>
            <div class="tab-pane <?php echo (($x == 0)? 'active' : ''); ?>" id="panel-<?php echo $dat; ?>">
                <div class="table-responsive">
                    <table class="table" border=1>
                        <tr>
                            <td colspan="2">Forum</td>
                            <td style="width: 5%;">Threads/posts</td>
                            <td style="width: 15%;">Latest post</td>
                        </tr>
                <?php
                    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                        $rQuery = $handler->query('SELECT COUNT(t.t_id) AS threadCount, SUM(t.postCount) AS postCount, t.lastdate, t.idFix FROM (SELECT t.t_id, CASE WHEN NOT ISNULL(p.postdate) AND p.postdate > t.postdate THEN p.postdate ELSE t.postdate END AS lastdate, CASE WHEN NOT ISNULL(p.u_id) THEN p.u_id ELSE t.u_id END AS idFix, COUNT(p.p_id) AS postCount FROM thread t LEFT OUTER JOIN (SELECT p.p_id, p.t_id, p.u_id, p.postdate FROM threadpost p ORDER BY p.postdate DESC) p ON p.t_id = t.t_id WHERE t.sc_id = '.$fetch['sc_id'].' GROUP BY t.t_id ORDER BY lastdate DESC) t');
                        $rFetch = $rQuery->fetch(PDO::FETCH_ASSOC);
                        $postedBy = $handler->prepare('SELECT * FROM users WHERE u_id = :u_id');
                        try{
                            $postedBy->execute([
                                ':u_id' => $rFetch['idFix']
                            ]);

                            $fetchBy = $postedBy->fetch(PDO::FETCH_ASSOC);
                        }catch(PDOException $e){
                            echo $e->getMessage();
                        }
                ?>
                <tr>
                    <td style="width: 64px;"><img src="" alt="" style="width: 64px; height: 64px;" /></td>
                    <td><a href="<?php echo $website_url . 'section/' . $fetch['secname']; ?>" style="font-weight: bold;"><?php echo $fetch['secname']; ?></a><br />
                        <?php echo $fetch['secdesc']; ?></td>
                    <td style="text-align: center;"><?php echo $rFetch['threadCount'] . '<br />' . $rFetch['postCount']; ?></td>
                    <td>
                        <?php
                            echo $fetchBy['username'] . '<br />';
                            echo $rFetch['lastdate']; ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
                    </table>
                </div>
            </div>
            <?php
                    $x++;
                }
            ?>
        </div>
    </div>
</div>
