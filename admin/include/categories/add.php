<div style="max-width: 50%;">
    <form method="post">
        <div class="input-group" style="margin-bottom: 5px;">
          <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
          <input class="form-control" type="text" name="name" placeholder="Category name" />
        </div>
        <div class="input-group pull-right" style="margin-bottom: 5px;">
        <input class="btn btn-success" type="submit" name="addthread" value="Submit" />
        </div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['addthread'])){
                if(!empty($_POST['name'])){
                    $name = $_POST['name'];
                    $check = $handler->prepare('SELECT * FROM category WHERE categoryname = :categoryname');
                    $check->execute([':categoryname' => $name]);
                    $fetch = $handler->query('SELECT * FROM category ORDER BY c_id desc');
                    $fetch = $fetch->fetch(PDO::FETCH_ASSOC);

                    if(!$check->rowCount()){
                        $corder = $fetch['c_id'] + 1;
                        echo perry('INSERT INTO category (categoryname, corder) VALUES (:name, :corder)', [':name' => $name, ':corder' => $corder], true);
                    }
                    else{
                        echo'<div class="message">' . $categoryExists . '</div>';
                    }
                }
                else{
                    echo $emptyerror;
                }
            }
        }
    ?>
</div>
