<?php
    if(is_dir('functions/')){
        $map = 'functions/';
    }
    else{
        $map = '../functions/';
    }

    $Directory = new RecursiveDirectoryIterator($map);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $objects = new RegexIterator($Iterator, '/^.+\.php$/i');

    foreach($objects as $name){
        require_once $name;
    }

    if(is_dir('plugins/')){
        $map = 'plugins/';
    }
    else{
        $map = '../plugins/';
    }

    $Directory = new RecursiveDirectoryIterator($map);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $objects = new RegexIterator($Iterator, '/^.+\.php$/i');

    foreach($objects as $name){
        require_once $name;
    }
?>
