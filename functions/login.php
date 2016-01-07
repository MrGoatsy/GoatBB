<?php
    //Login
    function login(){
        global $handler;
        global $redirect;
        global $incorrectpw;
        global $emptyerror;
        global $catcherror;
        global $notactive;

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
                    $_SESSION['user'] = $username;

                    header("Location: $redirect");
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
