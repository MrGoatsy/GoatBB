<?php
    if(isset($_GET['p']) && isset($_GET['userid'])){
        $userId = (int)$_GET['userid'];

        $query = $handler->prepare('SELECT * FROM users WHERE u_id = :uid');
        try{
            $query->execute([
                ':uid' => $userId
            ]);
        }catch(PDOException $e){
            echo $error;
        }

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        $queryT = $handler->query('SELECT COUNT(*) FROM thread WHERE u_id =' . $fetch['u_id']);
        $queryP = $handler->query('SELECT COUNT(*) FROM threadpost WHERE u_id =' . $fetch['u_id']);

        $fetchTcount = $queryT->fetch(PDO::FETCH_NUM);
        $fetchPcount = $queryP->fetch(PDO::FETCH_NUM);
?>
<div class="col-md-12">
    <h2>Profile</h2>
    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;" border=1>
                <tr>
                    <td colspan="4">
                        <table style="width: 100%;">
                            <tr>
                                <td class="threadtd" style="width: 64px;"><img src="http://i.imgur.com/q9DFazz.png" alt="" class="avatar" style="width: 96px; height: 96px;" /></td>
                                <td class="threadtd">
                                    <span style="font-size: 20px;"><?php echo $fetch['username']; ?></span><br />
                                    <?php echo $fetchRank['rankName']; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><br />
            <div class="row">
        		<div class="col-md-5">
                    <table style="width: 100%;" border=1>
                        <tr>
                            <td colspan="2"><span class="profileSpan"><strong>Profile information</strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><span class="profileSpan">Joined:</span></td>
                            <td style="width: 20%;"><span class="profileSpan"><?php echo substr($fetch['joindate'], 0, 7); ?></span></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><span class="profileSpan">Posts:</span></td>
                            <td style="width: 20%;"><span class="profileSpan"><?php echo $fetchTcount[0] + $fetchPcount[0]; ?></span></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><span class="profileSpan">Reputation:</span></td>
                            <td style="width: 20%;"><span class="profileSpan">0</span></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><span class="profileSpan">Website:</span></td>
                            <td style="width: 20%;"><span class="profileSpan"><?php echo ((!empty($fetch['website'])? "<a href='{$fetch['website']}'>{$fetch['website']}</a>" : 'None')); ?></span></td>
                        </tr>
                    </table>
        		</div>
        		<div class="col-md-1"><br />
        		</div>
        		<div class="col-md-6">
                    <table style="width: 100%;" border=1>
                        <tr>
                            <td colspan="2"><span class="profileSpan"><strong>Signature</strong></span></td>
                        </tr>
                        <tr>
                            <td style="height: 150px;"><span class="profileSpan"><?php echo $fetch['signature']; ?></span></td>
                        </tr>
                    </table>
        		</div>
        	</div>
        </div>
    </div>
</div>
<?php
    }
    else{
        echo $pagedoesnotexist;
    }
?>
