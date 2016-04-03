<div class="row">
    <div class="col-md-12">
<?php
    if(isset($banned) && $banned === 1){
 ?>
        <h2>Banned</h2>
        You have been banned from this forum.
<?php
        session_destroy();
    }
    else{
        echo $pagedoesnotexist;
    }
 ?>
    </div>
</div>
