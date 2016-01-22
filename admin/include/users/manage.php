<h3>Manage users</h3><br />
<div class="table-responsive">
    <form method="post">
    <table class="table">
        <tr>
            <td style="width: 60%;">Username</td>
            <td>Rank</td>
            <td>Warnings</td>
        </tr>
        <?php
            $query = $handler->query('SELECT * FROM users');
            if($query->rowCount()){
                $x = 0;
                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $queryW = $handler->query('SELECT *, sum(amount) as total FROM warnings WHERE u_id =' . $fetch['u_id']);
                    $fetchW = $queryW->fetch(PDO::FETCH_ASSOC);

                    $fetchW['total'] = $fetchW['total'] ?? 0;

                    echo'<tr>
                            <td>' . $fetch['username'] . '</td>
                            <td>' . $fetch['rank'] . '</td>
                            <td>' . $fetchW['total'] . '%</td>
                        </tr>';
                }
            }
            else{
                echo '<tr><td colspan="4">' . $noResultsDisplay . '</td></tr>';
            }
        ?>
            <tr><td colspan="4"><input type="submit" name="section" class="btn btn-primary pull-right" value="Submit" /></td></tr>
    </table>
    </form>
</div>
<?php
    if(isset($_GET['p'])){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
                if($_GET['p'] == 'del'){

                $query = $handler->prepare('SELECT * FROM section WHERE sc_id = :id');
                $query->execute([
                    ':id'   => $id
                ]);

                if($query->rowCount()){
                    if($_GET['p'] == 'del'){
                        echo perry('DELETE FROM section WHERE sc_id = :id', [':id' => $id], true);
                    }
                }
                else{
                    echo'<div class="message">' . $doesnotexist . '</div>';

                    header('refresh:2;url=index.php');
                }
            }
        }
    }
    elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['section'])){
            foreach($_POST as $data => $value){
                $id = trim(str_replace(range(0, 9), '', $data));
                if($data != 'section'){
                    if((int)$data){
                        echo perry('UPDATE section SET sorder = :sorder WHERE sc_id = :id', [':sorder' => $value, ':id' => $data], false);
                    }
                    if(trim(str_replace(range(0, 9), '', $data)) == 'category'){
                        $data = trim(str_replace(range('a', 'z'), '', $data));

                        echo perry('UPDATE section SET c_id = :cid WHERE sc_id = :id', [':id' => $data, ':cid' => $value], false);
                    }
                }
            }
            header('Location: index.php');
        }
    }
?>
