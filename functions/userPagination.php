<?php
    function userPagination(){
        global $pagenumber;
        global $pages;
 ?>
    <ul class="pagination pull-right">
        <?php
            $i = 1;
            echo'<li><a href="?pn=1">&lt;&lt;</a></li>';
            echo'<li><a href="?pn=' . ($pagenumber - 1) . '">&lt;</a></li>';

            while($i <= $pages){
                if(!($pagenumber <= $i-5) && !($pagenumber >= $i+5)){
        ?>
            <li <?php echo (($pagenumber === $i)? 'class="active"' : ''); ?>><a href="?pn=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
                }
                $i++;
            }

            echo'<li><a href="?pn=' . ($pagenumber + 1) . '">&gt;</a></li>';
            echo'<li><a href="?pn=' . $pages . '">&gt;&gt;</a></li>';
        ?>
    </ul>
<?php
    }
 ?>
