<?php
function perry($query, $execute, $redirect = false){
    global $handler;

    $perry = $handler->prepare($query);
    try{
        $perry->execute(
            $execute
        );

        if($redirect){
            header('Location: index.php');
        }
    }catch(PDOException $e){
        return $e->getMessage();
    }
}
 ?>
