<?php
    if(isset($_GET['p']) && isset($_GET['userid']) && isset($_GET['reputationOverview'])){
        $queryReputation = $handler->query('SELECT * FROM reputation WHERE u_id_recipient =' . $fetch['u_id']);
 ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Reputation overview</h2><hr />
                <table style="width: 100%" border=1>
                    <?php
                        if($queryReputation->rowCount()){
                            while($fetch = $queryReputation->fetch(PDO::FETCH_ASSOC)){
                                $queryRepBy = $handler->query('SELECT * FROM users WHERE u_id =' . $fetch['u_id_sender']);
                                $fetchRepBy = $queryRepBy->fetch(PDO::FETCH_ASSOC);
                     ?>
                        <tr>
                            <td style="width: 100px;"><div class="profileSpan"><?php echo $fetchRepBy['username']; ?></div></td>
                            <td style="width: 25px;"><div class="profileSpan" style="color: <?php echo (($fetch['repAmount'] >= 0)? 'green' : 'red'); ?>"><?php echo $fetch['repAmount']; ?></div></td>
                            <td><div class="profileSpan"><?php echo $fetch['repDesc']; ?><div></td>
                        </tr>
                    <?php
                            }
                        }
                        else{
                            echo $noReputation;
                        }
                    ?>
                </table>
            </div>
        </div>
<?php
    }
 ?>
