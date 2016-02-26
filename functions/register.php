<?php
    //Register
    function register(){
        global $handler;
        global $regsuccess;
        global $catcherror;
        global $passworderror;
        global $emptyerror;
        global $nomail;
        global $existingusername;
        global $existingemail;
        global $invalidchar;
        global $tooshort;
        global $website_url;
        global $contactemail;
        global $mailer;
        global $mail;
        global $error;

        if(!empty($_POST['username'])){
            if(!empty($_POST['email'])){
                if(!empty($_POST['password'])){
                    if(!empty($_POST['passwordconf'])){
                        if(empty($_POST['name'])){
                            $username       = $_POST['username'];
                            $email          = $_POST['email'];
                            $password       = $_POST['password'];
                            $passwordconf   = $_POST['passwordconf'];
                            $users          = $handler->query('SELECT * FROM users');
                            $usernamecheck  = $handler->prepare("SELECT * FROM users WHERE username = :username");
                            $emailcheck     = $handler->prepare("SELECT * FROM users WHERE email = :email");
                            $usernamecheck->execute([
                                ':username' => $username
                            ]);

                            $emailcheck->execute([
                                ':email'    => $email
                            ]);

                            $email_code     = md5($username + microtime());
                            $rank           = ((!$users->rowCount())? 999 : 1);

                            if(preg_match('/^[a-z\d]{2,255}$/i', $username)){
                                if(strlen($password) >= 5){
                                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                                        if(!$usernamecheck->rowCount()){
                                            if(!$emailcheck->rowCount()){
                                                if($password == $passwordconf){
                                                    $options = [
                                                        'cost' => 11
                                                    ];
                                                    $password   = password_hash($password, PASSWORD_BCRYPT, $options);

                                                    $query = $handler->prepare('INSERT INTO users (username, password, joindate, email, email_code, rank) VALUES (:username, :password, :joindate, :email, :email_code, :rank)');

                                                    try{
                                                    $query->execute(array(
                                                        ':username'     => $username,
                                                        ':password'     => $password,
                                                        ':joindate'     => date("Y-m-d H:i:s"),
                                                        ':email'        => $email,
                                                        ':email_code'   => $email_code,
                                                        ':rank'         => $rank
                                                    ));

                                                    if($mailer === '0'){
                                                        mail($email, 'Account activation', "Please click this link to activate your account:\r\n" . $website_url . "?p=activate&code=" . $email_code, "From: $contactemail");
                                                    }
                                                    elseif($mailer === '1'){
                                                        $mail->setFrom($contactemail);
                                                        $mail->addAddress($email);     // Add a recipient
                                                        $mail->isHTML(true);                                  // Set email format to HTML

                                                        $mail->Subject = 'Account activation';
                                                        $mail->Body    = "Please click this link to activate your account:\r\n" . $website_url . "?p=activate&code=" . $email_code;

                                                        if(!$mail->send()){
                                                            echo $error;
                                                        }
                                                    }

                                                    return $regsuccess;
                                                    }
                                                    catch(PDOException $e){
                                                        echo $e->getMessage();
                                                    }
                                                }
                                                else{
                                                    return $passworderror;
                                                }
                                            }
                                            else{
                                                return $existingemail;
                                            }
                                        }
                                        else{
                                            return $existingusername;
                                        }
                                    }
                                    else{
                                        return $nomail;
                                    }
                                }
                                else{
                                    return $tooshort;
                                }
                            }
                            else{
                                return $invalidchar;
                            }
                        }
                    }
                }
            }
        }
    }
?>
