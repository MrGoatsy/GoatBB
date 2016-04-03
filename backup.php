<script>
    window.onload = function() {
        var aCodes = document.getElementsByTagName('code');
        for (var i=0; i < aCodes.length; i++) {
            hljs.highlightBlock(aCodes[i]);
        }
    };
</script>
<div class="row">
  <div class="col-md-12" style="margin-top: 5px;">
      <h2>Installation</h2><br />
    <!-- tabs left -->
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab1">
            <li class="active"><a href="#a" onClick="window.location.reload()" data-toggle="tab">Extracting files</a></li>
            <li><a href="#b" onClick="window.location.reload()" data-toggle="tab">Configuring</a></li>
            <li><a href="#c" onClick="window.location.reload()" data-toggle="tab">Language</a></li>
            <li><a href="#d" onClick="window.location.reload()" data-toggle="tab">Uploading</a></li>
            <li><a href="#e" onClick="window.location.reload()" data-toggle="tab">Permissions</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="a">
                <table>
                    <tr>
                        <td>
                            <h2>Uploading files</h2>
                            Follow these steps:<br />
                            Unpack the files from `GoatBB.zip` into a map called `goatbb`, you can use a program such as WinRar for this.<br /><br />
                            This program can be found here:<br />
                            <a href="http://www.win-rar.com/">http://www.win-rar.com/</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="b">
                <table>
                    <tr>
                        <td>
                            <h2>Editing the config</h2>
                            You need to find `config.php` in the map and open it with a program such as `Notepad` or `Atom`.<br /><br />
                            For Atom you need to go to <a href="https://atom.io/">https://atom.io/</a> and click the download button.<br />
                            Notepad is the default text editor for Windows, so you don't need to download anything for that.<br /><br />
                            After you have opened the file you need to configure your database and the mail settings, you can do that by editing this:<br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <pre><code class="php"><?php include'text/config.txt'; ?></code></pre>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="c">
                <table>
                    <tr>
                        <td>
                            <h2>Editing the language</h2>
                            You need to find `lang.php` and open it with your favourite editor, if you don't have any check the previous tab for a brief guide on how to get one.<br /><br />
                            If you have `lang.php` opened, you can edit all the text you see in there to what you want, this is optional, so if you don't want to you don't have it.<br />
                            It should look something like this:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <pre><code class="php"><?php include htmlentities('text/lang.txt'); ?></code></pre>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="d">
                <table>
                    <tr>
                        <td>
                            <h2>Uploading files</h2>
                            Follow these steps:<br />
                            Connect to your FTP server<br />
                            Upload the files from the `goatbb` to your server<br /><br />
                            A more detailed guide on how FTP works can be found here:<br />
                            <a href="https://winscp.net/eng/docs/guides">https://winscp.net/eng/docs/guides</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="tab-pane" id="e">
                <table>
                    <tr>
                        <td>
                            <h2>Settings permissions</h2>
                            In order to get the avatar system to work you need to set the permissions of the map `avatars` to 777.<br /><br />
                            You can find the `avatars` map by going to the root map and then to the `images` map, once you are there right click on the map `avatars` and click `Change permissions` or `Properties`, it will now look similar to this:<br />
                            <img src="images/permissions.png" /><br />
                            Change it so that it looks like this:<br />
                            <img src="images/permissions2.png" /><br /><br />
                            Now the avatar uploading system should work.<br /><br />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- /tabs -->
  </div>
</div>
