<?php
    $query = $handler->prepare('SELECT * FROM thread WHERE t_id = :t_id');
    $query->execute([
        ':t_id' => $_GET['thread']
    ]);

    $fetch = $query->fetch(PDO::FETCH_ASSOC);

    if($query->rowCount()){
        $query = $handler->prepare('SELECT * FROM users WHERE u_id = :u_id');
        $query->execute([
            'u_id' => $fetch['u_id']
        ]);
        $fetchr = $query->fetch(PDO::FETCH_ASSOC);

        $query = $handler->prepare('SELECT COUNT(*) FROM thread WHERE u_id = :u_id');
        $query->execute([
            ':u_id' => $fetch['u_id']
        ]);
        $fetchTcount = $query->fetch(PDO::FETCH_ASSOC);
        $query = $handler->prepare('SELECT COUNT(*) FROM thread WHERE u_id = :u_id');
        $query->execute([
            ':u_id' => $fetch['u_id']
        ]);
        $fetchPcount = $query->fetch(PDO::FETCH_ASSOC);
?>
<div class="table-responsive">
    <table class="table" border=1>
<tr>
    <td>
        <table style="width: 100%;">
            <tr>
                <td class="threadtd" style="width: 64px;"><img src="" alt="" class="avatar" /></td>
                <td class="threadtd"><?php echo $fetchr['username']; ?></td>
                <td class="threadtd pull-right"></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td><?php echo $fetch['content']; ?></td>
</tr>
<tr>
    <td><a href="" class="btn btn-primary pull-right">Report</a></td>
</tr>
<?php
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
        $rcount = $handler->query('SELECT COUNT(*) FROM threadpost WHERE t_id = ' . $fetch['t_id']);
        $rfetch = $rcount->fetch(PDO::FETCH_NUM);
?>
<tr>
    <td><img src="" alt="" class="avatar" style="width: 64px; height: 64px;" /><?php echo $fetch['name']; ?><br /></td>
</tr>
<tr>
    <td><img src="" alt="" style="width: 64px; height: 64px;" /></td>
</tr>
<tr>
    <td><img src="" alt="" style="width: 64px; height: 64px;" /></td>
</tr>
<?php
    }
?>
    </table>
</div>
<?php
    }
    else{
        echo $threaddoesnotexist;
    }
?>
