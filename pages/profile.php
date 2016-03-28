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

        if($query->rowCount()){
            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            $queryRank = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetch['rank']);
            $fetchRank = $queryRank->fetch(PDO::FETCH_ASSOC);

            $queryT = $handler->query('SELECT (SELECT count(*) FROM thread WHERE u_id =' . $fetch['u_id'] . ') as threadCount, (SELECT count(*) FROM threadpost WHERE u_id =' . $fetch['u_id'] . ') as postCount, (SELECT sum(repAmount) FROM reputation WHERE u_id_recipient =' . $fetch['u_id'] . ') as reputation');
            $fetchDetails = $queryT->fetch(PDO::FETCH_ASSOC);

            if(isset($_GET['giveReputation'])){
                require_once'profile/giveReputation.php';
            }
            elseif(isset($_GET['reputationOverview'])){
                require_once'profile/reputationoverview.php';
            }
            else{
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
                                <td class="threadtd" style="width: 64px;"><img src="<?php echo $website_url . 'images/avatars/' . $fetch['avatar']; ?>" alt="" class="avatar" style="width: 96px; height: 96px;" /></td>
                                <td class="threadtd">
                                    <span style="font-size: 20px;"><?php echo $fetch['username']; ?></div> <?php echo (($fetchUser['u_id'] == $fetch['u_id'] && isset($_SESSION['goatbbuser']))? '<a href="' . $website_url . 'p/editprofile">[Edit]</a>' : ''); ?></span><br />
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
                            <td colspan="2"><div class="profileSpan"><strong>Profile information</strong></div></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><div class="profileSpan">Joined:</div></td>
                            <td style="width: 20%;"><div class="profileSpan"><?php echo substr($fetch['joindate'], 0, 7); ?></div></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><div class="profileSpan">Posts:</div></td>
                            <td style="width: 20%;"><div class="profileSpan"><?php echo $fetchDetails['threadCount'] + $fetchDetails['postCount']; ?></div></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><div class="profileSpan">Reputation:</div></td>
                            <td style="width: 20%;"><div class="profileSpan">
                                <?php echo ((isset($fetchDetails['reputation'])? $fetchDetails['reputation'] : '0')); ?> <?php echo (($fetchUser['u_id'] != $fetch['u_id'] && isset($_SESSION['goatbbuser']))? '<a href="' . $website_url . 'p/profile?userid=' . $fetch['u_id'] . '&giveReputation">[Give reputation]</a>' : ''); ?>
                                <?php echo '<a href="' . $website_url . 'p/profile?userid=' . $fetch['u_id'] . '&reputationOverview">[Overview]</a>'; ?>
                            </div></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><div class="profileSpan">Website:</div></td>
                            <td style="width: 20%;"><div class="profileSpan"><?php echo ((!empty($fetch['website'])? "<a href='{$fetch['website']}'>{$fetch['website']}</a>" : 'None')); ?></div></td>
                        </tr>
                    </table>
        		</div>
        		<div class="col-md-1"><br />
        		</div>
        		<div class="col-md-6">
                    <table style="width: 100%;" border=1>
                        <tr>
                            <td colspan="2"><div class="profileSpan"><strong>Signature</strong></div></td>
                        </tr>
                        <tr>
                            <td style="height: 150px; vertical-align: top;"><div style="margin-left: 5px;"><?php echo $fetch['signature']; ?></div></td>
                        </tr>
                    </table>
        		</div>
        	</div>
        </div>
    </div>
</div>
<?php
            }
        }
        else{
            echo $pagedoesnotexist;
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
