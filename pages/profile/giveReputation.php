<?php
    if(isset($_GET['p']) && isset($_GET['userid']) && isset($_GET['giveReputation'])){
        if(isset($_SESSION['user'])){
?>
        <div class="row">
            <div class="col-md-4">
                <h2>Give reputation</h2>
                You can give a user reputation here.
                <form method="post">
                    <select name="repAmount" class="form-control" style="margin-bottom: 5px;">
                        <?php
                            foreach(range($fetchPermissions['maxRep'], $fetchPermissions['minRep']) as $x){
                                echo'<option value="' . $x . '" style="color: ' . (($x > 0)? 'green' : 'red') . ';">' . (($x > 0)? '+' : '') . $x . '</option>';
                            }
                         ?>
                    </select>
                    <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                      <span class="input-group-addon"><i class="fa fa-plus fa-fw"></i></span>
                      <input class="form-control" type="text" name="repDesc" placeholder="Reason" />
                    </div>
                    <div class="input-group pull-right" style="margin-bottom: 5px;">
                        <input class="btn btn-success" type="submit" name="giveReputation" value="Submit" />
                    </div>
                </form>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST['giveReputation'])){
                            $repAmount = (int)$_POST['repAmount'];
                            $repDesc = $_POST['repDesc'];

                            if(filter_var($repAmount, FILTER_VALIDATE_INT, ['options' => ['min_range' => $fetchPermissions['minRep'], 'max_range' => $fetchPermissions['maxRep']]])){
                                $queryRepCheck = $handler->query('SELECT * FROM reputation WHERE u_id_recipient =' . $fetch['u_id'] . ' AND u_id_sender =' . $fetchUser['u_id']);

                                if($fetch['u_id'] == $fetchUser['u_id']){
                                    echo $addRepToSelf;
                                }
                                else{
                                    if($queryRepCheck->rowCount()){
                                        echo perry('UPDATE reputation SET u_id_recipient = :u_id_r, u_id_sender = :u_id_s, repAmount = :repAmount, repDesc = :repDesc WHERE u_id_recipient =' . $fetch['u_id'] . ' AND u_id_sender =' . $fetchUser['u_id'], [':u_id_r' => $fetch['u_id'], ':u_id_s' => $fetchUser['u_id'], ':repAmount' => $repAmount, ':repDesc' => $repDesc]);
                                        echo $repUpdated;
                                    }
                                    else{
                                        echo perry('INSERT INTO reputation (u_id_recipient, u_id_sender, repAmount, repDesc) VALUES (:u_id_r, :u_id_s, :repAmount, :repDesc)', [':u_id_r' => $fetch['u_id'], ':u_id_s' => $fetchUser['u_id'], ':repAmount' => $repAmount, ':repDesc' => $repDesc]);
                                        echo $repAdded;
                                    }
                                }
                            }
                            else{
                                echo $repError;
                            }
                        }
                    }
                 ?>
            </div>
        </div>
<?php
        }
        else{
            echo $pagedoesnotexist;
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
