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
                    <td colspan="2">
                        <table style="width: 100%;">
                            <tr>
                                <td class="threadtd" style="width: 64px;"><img src="http://i.imgur.com/q9DFazz.png" alt="" class="avatar" style="width: 96px; height: 96px;" /></td>
                                <td class="threadtd">
                                    <?php echo $fetch['username']; ?><br />
                                    Posts: <?php echo $fetchTcount[0] + $fetchPcount[0]; ?><br />
                                    Joined: <?php echo substr($fetch['joindate'], 0, 7); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
        </table>
        </div>
    </div>
</div>
<?php
    }
    else{
        echo $pagedoesnotexist;
    }
?>
