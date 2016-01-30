<?php
    if(isset($_SESSION['user'])){
        if(isset($_GET['s'])){
            $section = (int)$_GET['s'];
            $query = $handler->prepare('SELECT * FROM section WHERE sc_id = :sc_id');
            $query->execute([
                ':sc_id' => $section
            ]);

            if($query->rowCount()){
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
?>
        <div style="width: 50%; margin: 0 auto;">
            <h2>Post a thread</h2>
            You are now posting a thread to <span style="color: rgb(16, 145, 0);"><?php echo $fetch['secname']; ?></span>.<br /><br />
            <form method="post">
                <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                  <input class="form-control" type="text" name="title" placeholder="Title" />
                </div>
                <textarea name="thread" id="thread"></textarea>
                <script>
                    $('#thread').summernote({
                        height: 250,
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
                    <input class="btn btn-success" type="submit" name="postThread" value="Submit" />
                </div>
            </form>
        </div>
<?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(isset($_POST['postThread'])){
                        if(!empty($_POST['title']) && !empty($_POST['thread'])){
                            $title = htmlentities($_POST['title'], ENT_QUOTES);
                                $thread = $_POST['thread'];
                                $thread = $purifier->purify($thread);
                                //$thread = strip_tags($thread, '<h1><h2><h3><h4><h5><h6><pre><blockquote><p><b><i><u><font><span><ul><li><table><tr><td><a><img><hr><br>');

                                echo perry('INSERT INTO thread (sc_id, u_id, title, content) VALUES (:sc_id, :u_id, :title, :content)', [':sc_id'=> $section, ':u_id' => $fetchUser['u_id'], 'title' => $title, ':content' => $thread]);

                                $threadId = $handler->prepare('SELECT * FROM thread WHERE title = :title ORDER BY postdate DESC');

                                try{
                                    $threadId->execute([
                                        ':title' => $title
                                    ]);
                                }catch(PDOException $e){
                                    echo $error;
                                }

                                $fetchThreadId = $threadId->fetch(PDO::FETCH_ASSOC);

                                header('Location: ' . $website_url . 'thread/' . $fetchThreadId['t_id']);
                        }
                        else{
                            echo $emptyerror;
                        }
                    }
                }
            }
        }
    }
?>
