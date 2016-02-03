<?php
    foreach(glob("{$path}/functions/*.php") as $filename){
        require_once $filename;
    }
    foreach(glob("{$path}/plugins/*.php") as $filename){
        require_once $filename;
    }
?>
