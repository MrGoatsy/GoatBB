<form method="post">
    <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
      <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
      <input class="form-control" type="text" name="recipient" placeholder="To" />
    </div>
    <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
      <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
      <input class="form-control" type="text" name="subject" placeholder="Subject" />
    </div>
    <textarea name="messageReply" id="messageReply"></textarea>
    <script>
        $('#messageReply').summernote({
            height: 150,
            // toolbar
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'italic', 'underline', 'clear']],
              // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
              ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'hr']],
              ['view', ['fullscreen']],   // remove codeview button
              ['help', ['help']]
            ]
        });
    </script>
    <div class="input-group pull-right" style="margin-bottom: 5px;">
        <input class="btn btn-success" type="submit" name="postMessage" value="Submit" />
    </div>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['postMessage'])){
            $checkMessage = $handler->query('SELECT * FROM messages WHERE u_id_sender =' . $fetchUser['u_id'] . ' ORDER BY messageDate DESC LIMIT 1');
            $fetchMessageDate = $checkMessage->fetch(PDO::FETCH_ASSOC);
            $postDate = strtotime($fetchMessageDate['messageDate']);
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if($currentDate - $postDate >= $fetchPermissions['postTime']){
                if(!empty($_POST['messageReply'])){
                    $recipient = htmlentities($_POST['recipient'], ENT_QUOTES);
                    $checkRecipient = $handler->prepare('SELECT * FROM users WHERE username = :username');
                    $checkRecipient->execute([':username' => $recipient]);
                    $fetchRecipient = $checkRecipient->fetch(PDO::FETCH_ASSOC);
                    
                    if($checkRecipient->rowCount()){
                        $subject = htmlentities($_POST['subject'], ENT_QUOTES);
                        $messageReply = $_POST['messageReply'];
                        $messageReply = $purifier->purify($messageReply);

                        if(strlen($messageReply)){
                            echo perry('INSERT INTO messages (u_id_sender, u_id_recipient, subject, content, messageDate)
                            VALUES (:uidsender, :uidrecipient, :subject, :content, :messagedate)',
                            [':uidsender'=> $fetchUser['u_id'],':uidrecipient' => $fetchRecipient['u_id'], ':subject' => $subject, ':content' => $messageReply, ':messagedate' => date("Y-m-d H:i:s")]);

                            header("Refresh:0;url={$website_url}p/messages");
                        }
                        else{
                            echo $messageTooShort;
                        }
                    }
                    else{
                        echo $userDoesNotExist;
                    }
                }
                else{
                    echo $emptyerror;
                }
            }
            else{
                echo'
                    <div class="alert alert-danger fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      ' . $pleaseWait . '
                    </div>';
            }
        }
    }
?>
