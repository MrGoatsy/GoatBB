<div style="max-width: 50%;">
    <form method="post">
        <div class="input-group" style="margin-bottom: 5px;">
          <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
          <input class="form-control" type="text" name="name" placeholder="Section name" />
        </div>
        <?php
            $query = $handler->query('SELECT * FROM category');

            echo'Category: <select name="category" class="form-control" size="1">';

            while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                echo'<option value="' . $fetch['c_id'] . '">' . $fetch['categoryname'] . '</option>';
            }
            echo'
            </select>
            ';
        ?><br />
        <div class="input-group" style="margin-bottom: 5px;">
          <span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i></span>
          <input class="form-control" type="text" name="description" placeholder="Short description" />
        </div>
        <div class="input-group pull-right" style="margin-bottom: 5px;">
        <input class="btn btn-success" type="submit" name="addsec" value="Submit" />
        </div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['addsec'])){
                if(!empty($_POST['name'])){
                    $name = $_POST['name'];
                    $desc = ((!empty($_POST['description']))? $_POST['description'] : '');
                    $check = $handler->prepare('SELECT * FROM section WHERE secname = :secname');
                    $check->execute([':secname' => $name]);
                    $fetch = $handler->query('SELECT * FROM section ORDER BY sc_id desc');
                    $fetch = $fetch->fetch(PDO::FETCH_ASSOC);

                    if(!$check->rowCount()){
                        $corder = $fetch['sc_id'] + 1;
                        $cid = $_POST['category'];

                        echo perry('INSERT INTO section (secname, secdesc, c_id, sorder) VALUES (:name, :desc, :c_id, :corder)', [':name' => $name, ':desc' => $desc, ':c_id' => $cid, ':corder' => $corder], true);
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
