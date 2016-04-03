<?php
function userMonth(){
    global $handler;

    $userArray = [];

    for($x = 1; $x <= 12; $x++){
        $joindate = date("Y") . '-' . (($x < 10)? '0' . $x : $x);

        $getUsersMonth = $handler->prepare('SELECT COUNT(*) as userCount FROM users WHERE joindate LIKE :joindate');
        $getUsersMonth->execute([':joindate' => "%{$joindate}%"]);

        $userArray[] .= $getUsersMonth->fetch(PDO::FETCH_ASSOC)['userCount'];
    }

    return json_encode($userArray);
}
?>
