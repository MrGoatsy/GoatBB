<div style="max-width: 50%;">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td style="width: 60%;">Category name</td>
                <td>Edit category</td>
                <td>Order</td>
            </tr>
            <form method="post">
            <?php
                $query = $handler->query('SELECT * FROM category ORDER BY corder');

                if($query->rowCount()){
                    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                        echo'
                            <tr>
                                <td><strong>' . $fetch['categoryname'] . '</strong><br /></td>
                                <td><a class="btn btn-warning" href="index.php?p=edit&id=' . $fetch['c_id'] . '"><i class="fa fa-times fa-fw"></i> Edit</a>
                                <a class="btn btn-danger" href="index.php?p=del&id=' . $fetch['c_id'] . '"><i class="fa fa-times fa-fw"></i> Delete</a></td>
                                <td><input type="number" class="form-control" name="' . $fetch['c_id'] . '" value="' . $fetch['corder'] . '" style="width: 60px;" /></td>
                            </tr>
                        ';
                    }
                }
                else{
                    echo '<tr><td>' . $noResultsDisplay . '</td><td></td></tr>';
                }
            ?>
                <tr><td colspan="4"><input type="submit" name="order" class="btn btn-primary pull-right" value="Submit" /></td></tr>
            </form>
        </table>
    </div>
</div>
<?php
    if(isset($_GET['p'])){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
                if($_GET['p'] == 'del'){

                $query = $handler->prepare('SELECT * FROM category WHERE c_id = :id');
                $query->execute([
                    ':id'   => $id
                ]);
                $mquery = $handler->query('SELECT * FROM category');

                if($query->rowCount()){
                    if($mquery->rowCount() == 1){
                        echo'<div class="message">' . $lastCategory . '</div>';
                    }
                    else{
                        if($_GET['p'] == 'del'){
                            echo perry('DELETE FROM category WHERE c_id = :id', [':id' => $id], true);
                        }
                    }
                }
                else{
                    echo'<div class="message">' . $doesnotexist . '</div>';
                }
            }
        }
    }
    elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['order'])){
            foreach($_POST as $data => $value){
                if($data != 'order'){
                    $corder = (int)$value;

                    echo perry('UPDATE category SET corder = :corder WHERE c_id = :id', [':corder' => $corder, ':id' => $data], true);
                }
            }
        }
    }
 ?>
