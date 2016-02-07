<?php
    //Check if the url is safe.
    function urlCheck($string){
        if(empty($string)){
            return true;
        }
        else{
            if(filter_var($string, FILTER_VALIDATE_URL)){
                return true;
            }
            else{
                return false;
            }
        }
    }
 ?>
