<?php
    if(isset($_SESSION['user'])){
?>
        <div class="row">
            <div class="col-md-5">
                <h2>Edit profile</h2>
                You can edit your profile here.
                <form method="post">
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
                        <input class="btn btn-success" type="submit" name="giveReputation" value="Submit" />
                    </div>
                </form>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        $website = $purifier->purify($_POST['website']);
                        $signature = $purifier->purify($_POST['signature']);

                        if(urlCheck($website)){
                            echo perry('UPDATE users SET website = :website, signature = :signature', [':website' => $website, ':signature' => $signature]);
                            echo $profileUpdated;
                        }
                    }
                 ?>
            </div>
        </div>
<?php
    }
 ?>
