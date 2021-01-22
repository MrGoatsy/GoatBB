<?php
    //Login
    function login(){
        global $handler;
        global $redirect;
        global $incorrectpw;
        global $emptyerror;
        global $catcherror;
        global $notactive;
        global $uniqueCode;

        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $username       = $_POST['username'];
            $password       = $_POST['password'];
            $checkuser      = $handler->prepare("SELECT * FROM users WHERE username = :username");
            $checkuser->execute([
                ':username' => $username
                ]);

            $fetch          = $checkuser->fetch(PDO::FETCH_ASSOC);
            $pw             = $fetch['password'];

            if(password_verify($_POST['password'], $pw)){
                if($fetch['active'] == 1){
                    if($fetch['rank'] != 0){
                        $_SESSION[$uniqueCode] = $username;

                        header("Location: $redirect");
                    }
                    else{
                        return $banned;
                    }
                }
                else{
                    return $notactive;
                }
            }
            else{
                return $incorrectpw;
            }
        }
        else{
            return $emptyerror;
        }
    }
?>
