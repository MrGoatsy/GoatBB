<h3>Manage Sections</h3><br />
<div class="tabbable">
    <ul class="nav nav-tabs" id="categoryTabId">
        <li class="active"><a href="#200" data-toggle="tab">Add section</a></li>
        <li><a href="#201" data-toggle="tab">Edit section</a></li>
    </ul>
    <div class="tab-content"><br />
        <div class="tab-pane active" id="200">
            <?php
                require_once'add.php';
             ?>
        </div>
        <div class="tab-pane" id="201">
            <?php
                require_once'list.php';
            ?>
        </div>
    </div>
</div>
