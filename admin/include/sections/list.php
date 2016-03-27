<div class="table-responsive">
    <form method="post">
    <table class="table">
        <tr>
            <td style="width: 60%;">Section name</td>
            <td>Edit section</td>
            <td>Category</td>
            <td>Order</td>
        </tr>
        <?php

            $cquery = $handler->query('SELECT * FROM category');
            $categories = $cquery->fetchAll();

            $query = $handler->query('SELECT * FROM section ORDER BY sorder');
            if($query->rowCount()){
                while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                    $options = '';
                    foreach ($categories as $cfetch) {
                        $options .= '<option value="' . $cfetch['c_id'] . '" ' . (($cfetch['c_id'] == $fetch['c_id']) ? 'selected' : '') . '>' . $cfetch['categoryname'] . '</option>';
                    }
                    echo'
                        <tr>
                            <td><strong>' . $fetch['secname'] . '</strong><br />' . $fetch['secdesc'] . '</td>
                            <td><a class="btn btn-warning" href="index.php?p=edit&id=' . $fetch['sc_id'] . '"><i class="fa fa-times fa-fw"></i> Edit</a>
                            <a class="btn btn-danger" href="index.php?p=del&id=' . $fetch['sc_id'] . '"><i class="fa fa-times fa-fw"></i> Delete</a></td>
                            <td><select name="category' . $fetch['sc_id'] . '" class="form-control" size="1">
                            ' . $options . '
                            </select></td>
                            <td><input type="number" class="form-control" name="' . $fetch['sc_id'] . '" value="' . $fetch['sorder'] . '" style="width: 60px;" /></td>
                        </tr>
                    ';
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
