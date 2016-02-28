<?php
    if(isset($_GET['p']) && $_GET['p'] == 'search'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['submitSearch'])){
                $searchValue = $_POST['searchValue'];
                $searchQuery = $handler->prepare("SELECT * FROM thread WHERE title LIKE :searchValue OR content LIKE :searchValue");
                $searchQuery->execute([
                    ':searchValue' => "%{$searchValue}%"
                ]);
?>
    <div class="table-responsive">
        <table class="table" border=1>
            <tr>
                <td colspan="3">Search results</td>
            </tr>
            <tr>
                <td>Title</td>
                <td>Section</td>
                <td>Replies</td>
            </tr>
            <?php
                if($searchQuery->rowCount()){
                    while($fetchSearch = $searchQuery->fetch(PDO::FETCH_ASSOC)){
                        $querySection = $handler->query('SELECT * FROM section WHERE sc_id =' . $fetchSearch['sc_id']);
                        $queryCountPosts = $handler->query('SELECT count(p_id) as postCount FROM threadpost WHERE t_id =' . $fetchSearch['t_id']);
                        $sectionFetch = $querySection->fetch(PDO::FETCH_ASSOC);
                        $countPostsFetch = $queryCountPosts->fetch(PDO::FETCH_ASSOC);
             ?>
            <tr>
                <td><a href="<?php echo $website_url; ?>thread/<?php echo $fetchSearch['t_id']; ?>"><?php echo $fetchSearch['title']; ?></a></td>
                <td><?php echo $sectionFetch['secname']; ?></td>
                <td><?php echo $countPostsFetch['postCount']; ?></td>
            </tr>
            <?php
                    }
                }
                else{
            ?>
                   <tr>
                       <td colspan="3"><?php echo $noSearchResults; ?></td>
                   </tr>
           <?php
                }
             ?>
        </table>
    </div>
<?php
            }
        }
    }
    else{
        echo $pagedoesnotexist;
    }
?>
