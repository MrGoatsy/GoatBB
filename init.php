<?php
    foreach (glob("{$path}/functions/*.php") as $filename){
        require_once $filename;
    }
?>
