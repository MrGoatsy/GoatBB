<?php
    if(isset($_GET['p']) && isset($_GET['userid']) && isset($_GET['giveReputation'])){
?>
        <div class="row">
            <div class="col-md-4">
                <h2>Give reputation</h2>
                You can give a user reputation here.
                <form method="post">
                    <select name="repAmount" class="form-control" style="margin-bottom: 5px;">
                      <option value="1" style="color: green;">+1</option>
                      <option value="0">0</option>
                      <option value="-1" style="color: red;">-1</option>
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

                            if(filter_var($repAmount, FILTER_VALIDATE_INT, ['options' => ['min_range' => -1, 'max_range' => 1]])){
                                perry('INSERT INTO reputation (u_id_recipient, u_id_sender, repAmount, repDesc) VALUES (:u_id_r, :u_id_s, :repAmount, :repDesc)', [':u_id_r' => $fetch['u_id'], ':u_id_s' => $fetchUser['u_id'], ':repAmount' => $repAmount, ':repDesc' => $repDesc]);
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
 ?>
