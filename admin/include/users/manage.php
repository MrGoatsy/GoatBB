<h3>Manage users</h3><br />
<div class="table-responsive">
    <form method="post">
    <table class="table">
        <tr>
            <td>UID</td>
            <td style="width: 60%;">Username</td>
            <td>Rank</td>
            <td>Warnings</td>
            <td>Warn/Ban</td>
        </tr>
        <?php
            $query = $handler->query('SELECT * FROM users');
            if($query->rowCount()){
                $x = 0;
                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $queryW = $handler->query('SELECT *, sum(amount) as total FROM warnings WHERE u_id =' . $fetch['u_id']);
                    $fetchW = $queryW->fetch(PDO::FETCH_ASSOC);

                    $queryRank = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetch['rank']);
                    $fetchRank = $queryRank->fetch(PDO::FETCH_ASSOC);

                    $fetchW['total'] = $fetchW['total'] ?? 0;

                    if($fetchW['total'] >= 100 && $fetch['rank'] != 999){
                        $handler->query('UPDATE users SET rank = 0 WHERE u_id =' . $fetch['u_id']);
                    }

                    echo'<tr>
                            <td>' . $fetch['u_id'] . '</td>
                            <td>' . $fetch['username'] . '<br />' . $fetchRank["rankName"] . '</td>
                            <td>' . $fetch['rank'] . '</td>
                            <td>' . $fetchW['total'] . '%</td>
                            <td>
                                <select class="form-control" name="' . $fetch['u_id'] . '">
                                    <option value=""></option>
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                    <option value="40">40%</option>
                                    <option value="50">50%</option>
                                    <option value="60">60%</option>
                                    <option value="70">70%</option>
                                    <option value="80">80%</option>
                                    <option value="90">90%</option>
                                    <option value="100">100%</option>
                                </select>
                                <input type="text" placeholder="Reason" class="form-control" name="-' . $fetch['u_id'] . '">
                            </td>
                        </tr>';
                }
            }
            else{
                echo '<tr><td colspan="4">' . $noResultsDisplay . '</td></tr>';
            }
        ?>
            <tr><td colspan="5"><input type="submit" name="userManage" class="btn btn-primary pull-right" value="Submit" /></td></tr>
    </table>
    </form>
</div>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['userManage'])){
            foreach($_POST as $key => $value){
                if((int)$key && $key > 0){
                    if(!empty($value)){
                        perry('INSERT INTO warnings (u_id, amount) VALUES (:uid, :amount)', [':uid' => $key, ':amount' => $value]);
                    }
                }
                if((int)$key && $key < 0){
                    if(!empty($value) && !empty($_POST[abs($key)])){
                        perry('UPDATE warnings SET reason = :reason WHERE u_id =' . abs($key), [':reason' => $value]);
                    }
                }
            }
        }
    }
?>
