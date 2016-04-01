<?php
    if(isset($_SESSION[$uniqueCode])){
?>
        <div class="row">
            <div class="col-md-5">
                <h2>Edit profile</h2>
                You can edit your profile here.
                <form method="post" enctype="multipart/form-data">
                    <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                      <span class="input-group-addon"><i class="fa fa-picture-o fa-fw"></i></span>
                      <input class="form-control" type="file" name="avatar" placeholder="Avatar" />
                    </div>
                    <div class="input-group margin-bottom-sm" style="margin-bottom: 5px;">
                      <span class="input-group-addon"><i class="fa fa-plus fa-fw"></i></span>
                      <input class="form-control" type="text" name="website" placeholder="Website" value="<?php echo $fetchUser['website']; ?>" />
                    </div>
                    <label for="signature">Signature:</label>
                    <textarea name="signature" id="signature"><?php echo $fetchUser['signature']; ?></textarea>
                    <script>
                        $('#signature').summernote({
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
                        <input class="btn btn-success" type="submit" name="editProfile" value="Submit" />
                    </div>
                </form>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $website = $purifier->purify($_POST['website']);
                        $signature = $purifier->purify($_POST['signature']);

                        if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] != 4){
                            $avatar = $_FILES['avatar'];

                            $file_name = $avatar['name'];
                            $file_tmp = $avatar['tmp_name'];
                            $file_size = $avatar['size'];
                            $file_error = $avatar['error'];

                            $file_ext = explode('.', $file_name);
                            $file_ext = strtolower(end($file_ext));

                            $allowed = ['jpg', 'jpeg', 'png'];

                            if(in_array($file_ext, $allowed)){
                                if($file_error === 0){
                                    if($file_size <= 1000000){
                                        $file_name_new = $fetchUser['u_id'] . '.' . $file_ext;
                                        $file_destination = 'images/avatars/' . $file_name_new;

                                        if(urlCheck($website)){
                                            if(move_uploaded_file($file_tmp, $file_destination)){
                                                echo perry('UPDATE users SET website = :website, signature = :signature, avatar = :avatar WHERE u_id =' . $fetchUser['u_id'], [':website' => $website, ':signature' => $signature, ':avatar' => $file_name_new]);

                                                header('Location: ' . $website_url . 'p/editprofile');
                                            }
                                            else{
                                                echo $couldNotMoveFile;
                                            }
                                        }
                                        else{
                                            echo $notAWebsite;
                                        }
                                    }
                                    else{
                                        echo $imageTooBig;
                                    }
                                }
                                else{
                                    echo $error;
                                }
                            }
                            else{
                                echo $imageNotAllowed;
                            }
                        }
                        else{
                            if(urlCheck($website)){
                                echo perry('UPDATE users SET website = :website, signature = :signature WHERE u_id =' . $fetchUser['u_id'], [':website' => $website, ':signature' => $signature]);

                                header('Location: ' . $website_url . 'p/editprofile');
                            }
                            else{
                                echo $notAWebsite;
                            }
                        }
                    }
                 ?>
            </div>
        </div>
<?php
    }
 ?>
