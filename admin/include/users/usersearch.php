<h3>Search users</h3>
You can either search by UID or by username.
<div class="row">
    <div class="col-md-4">
        <form method="POST">
            <div class="form-group">
              <label for="name">UID/Name:</label>
              <input type="text" name="search" class="form-control" id="name" autocomplete="off" />
            </div>
            <label class="radio-inline"><input type="radio" name="option" value="uid" checked>UID</label>
            <label class="radio-inline"><input type="radio" name="option" value="username">Username</label><br />
            <input type="submit" name="searchButton" class="btn btn-success pull-right" value="Search" />
        </form>
    </div>
</div>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['searchButton'])){
            $search = $_POST['search'];
            $querypage = $handler->prepare("SELECT * FROM users WHERE " . (($_POST['option'] == 'uid')? 'u_id' : 'username') . " LIKE :search");
            try{$querypage->execute([':search' => "%{$search}%"]);} catch(PDOException $e){echo $error;}
?>
        <table class="table">
        <form method="post">
            <tr>
                <td>UID</td>
                <td style="width: 60%;">Username</td>
                <td>Rank</td>
                <td>Warnings</td>
                <td>Warn/Ban</td>
            </tr>
            <?php
                if($querypage->rowCount()){
                    $x = 0;
                    while($fetch = $querypage->fetch(PDO::FETCH_ASSOC)){
                        $queryW = $handler->query('SELECT *, sum(amount) as total FROM warnings WHERE u_id =' . $fetch['u_id'] . ' AND archived = 0');
                        $fetchW = $queryW->fetch(PDO::FETCH_ASSOC);

                        $queryRank = $handler->query('SELECT * FROM ranks WHERE rankValue =' . $fetch['rank']);
                        $fetchRank = $queryRank->fetch(PDO::FETCH_ASSOC);

                        $fetchW['total'] = $fetchW['total'] ?? 0;

                        if($fetchW['total'] >= 100 && $fetch['rank'] != 999){
                            perry('UPDATE users SET rank = 0 WHERE u_id = :uid', [':uid' => $fetch['u_id']]);
                        }
                        elseif($fetchW['total'] == 0 && $fetch['rank'] != 999){
                            perry('UPDATE users SET rank = 1 WHERE u_id = :uid', [':uid' => $fetch['u_id']]);
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
                                    <a href="?uid=' . $fetch['u_id'] . '&reset" class="btn btn-warning pull-right">Reset warning level</a>
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
<?php
        }
    }
?>
