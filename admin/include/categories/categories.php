<h3>Manage categories</h3><br />
<div class="tabbable">
    <ul class="nav nav-tabs" id="categoryTabId">
        <li class="active"><a href="#100" data-toggle="tab">Add category</a></li>
        <li><a href="#101" data-toggle="tab">Edit category</a></li>
    </ul>
    <div class="tab-content"><br />
        <div class="tab-pane active" id="100">
            <?php
                require_once'add.php';
             ?>
        </div>
        <div class="tab-pane" id="101">
            <?php
                require_once'list.php';
            ?>
        </div>
    </div>
</div>
