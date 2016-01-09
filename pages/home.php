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
                    $query = $handler->query('SELECT * FROM section WHERE c_id = ' . $dat . ' ORDER BY sorder');
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
                        $rcount = $handler->query('SELECT COUNT(*) FROM thread WHERE sc_id = ' . $fetch['sc_id'] . ' AND archived = 0');
                        $rfetch = $rcount->fetch(PDO::FETCH_NUM);
                ?>
                <tr>
                    <td style="width: 64px;"><img src="" alt="" style="width: 64px; height: 64px;" /></td>
                    <td><a href="<?php echo $website_url . 'section/' . $fetch['secname']; ?>" style="font-weight: bold;"><?php echo $fetch['secname']; ?></a><br />
                        <?php echo $fetch['secdesc']; ?></td>
                    <td><?php echo $rfetch[0]; ?></td>
                    <td></td>
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
