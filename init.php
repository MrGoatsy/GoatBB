<?php
    $map = ((is_dir('functions/'))? 'functions/' : '../functions/');

    $Directory = new RecursiveDirectoryIterator($map);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $objects = new RegexIterator($Iterator, '/^.+\.php$/i');

    foreach($objects as $name){
        require_once $name;
    }

    $map = ((is_dir('plugins/')? 'plugins/' : '../plugins/'));

    $Directory = new RecursiveDirectoryIterator($map);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $objects = new RegexIterator($Iterator, '/^.+\.php$/i');

    foreach($objects as $name){
        require_once $name;
    }
?>
