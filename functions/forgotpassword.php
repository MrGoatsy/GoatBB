<?php
    function forgotpassword(){
        global $handler;
        global $mailer;
        global $mail;
        global $emptyerror;
        global $catcherror;
        global $notactive;
        global $emailDoesNotExist;
        global $website_url;
        global $error;
        global $contactemail;

        if(!empty($_POST['email'])){
            $email      = $_POST['email'];
            $checkuser  = $handler->prepare("SELECT * FROM users WHERE email = :email");
            $checkuser->execute([
                ':email' => $email
                ]);

            if($checkuser->rowCount()){
                $fetch = $checkuser->fetch(PDO::FETCH_ASSOC);
                $password = randString(10);

                if($mailer === '0'){
                    mail($email, 'Password reset', "You requested a new password for your account on {$website_url}:<br />\r\n
                    Your username is: {$fetch['username']}<br />
                    Your new password is: {$password}<br /><br />
                    It is safer if your password when you login.",
                    "From: $contactemail");
                }
                elseif($mailer === '1'){
                    $mail->setFrom($contactemail);
                    $mail->addAddress($email);     // Add a recipient
                    $mail->isHTML(true);           // Set email format to HTML

                    $mail->Subject = 'Password reset';
                    $mail->Body    = "You requested a new password for your account on {$website_url}:<br />\r\n
                    Your username is: {$fetch['username']}<br />
                    Your new password is: {$password}<br /><br />
                    It is safer if your password when you login.";

                    if(!$mail->send()){
                        echo $error;
                    }
                }
                $options = [
                    'cost' => 11
                ];
                $password   = password_hash($password, PASSWORD_BCRYPT, $options);

                perry('UPDATE users SET password = :password WHERE email = :email', [':password' => $password, ':email' => $fetch['email']]);

                setcookie('newpassword', 'newpassword', time()+10);
                header("refresh:0;url={$website_url}p/login");
            }
            else{
                echo $emailDoesNotExist;
            }
        }
    }
?>
