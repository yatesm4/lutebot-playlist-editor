<?php
include 'config.php';

// Page load and post-processing here

if(isset($_FILES['midiUploads']) && count($_FILES['midiUploads']))
{
    $_UPLOADS = $_FILES['midiUploads'];
    foreach($_UPLOADS as $file)
    {
        // process file
        array_push($_RESULTS, validate_file($file, "midi"));
    }
}
?>

<!-- BEGIN HTML DOC -->
<html>
    <head>
        <title>LuteBot Playlist Editor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- FAVICON SETTINGS -->
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
        <link rel="manifest" href="img/favicon/site.webmanifest">
        <!-- CSS -->
        <link rel="stylesheet" href="simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- JS -->
        <script src="js/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body>
        <div class="container">

            <!-- BEGIN CONTENT HEAD -->
            <div class="content head">
                <h1><i class="icon-music-tone"></i>&nbsp;LuteBot Playlist Editor</h1>
            </div>

            <!-- BEGIN CONTENT BODY -->
            <div class="content body">
                <div class="upload-form-container">
                    <div class="content description">
                        <p>Easily create playlists for <a href="https://mordhau.com/forum/topic/13519/mordhau-lute-bot/">LuteBot</a>, an community-made mod/tool to 'enhance' your Mordhau experience. A massive collection of MIDI files for use can be found at <a href="http://en.midimelody.ru/">Midi Melody</a>.</p>
                    </div>
                    <!-- BEGIN UPLOAD FORM -->
                    <div class="content form">
                        <form action="generate_playlist.php" id="midi-upload-form" enctype="multipart/form-data">
                            <div class="form-head">
                                <h2>Browse and select the MIDI files you want to add to a playlist</h2>
                                <div class="form-controls">
                                    <div class="form-control">
                                        <input class="browse-files" name="midiUploads[]" id="midiUploads" type="file" multiple>
                                    </div>
                                    <div class="form-control">
                                        <label for="playlistName">Playlist Name:</label>
                                        <input class="playlist-name" name="playlistName" id="playlistName" type="text" placeholder="My Playlist">
                                    </div>
                                    <div class="form-control">
                                        <label for="playlistName">Client File Path:</label>
                                        <input class="path-name" name="pathName" id="pathName" type="text" placeholder="ex, C:\Users\[USERNAME]\Desktop\Applications\LuteBot\LuteBot 1.2\SongProfiles">
                                    </div>
                                    <div class="form-control">
                                        <input class="playlist-submit" name="submit" id="submit" value="Create Playlist" type="submit">
                                    </div>
                                </div>
                            </div>
                            <div class="selected-files">
                                <div class="uploaded-file">Upload some MIDI files to get started!</div>
                            </div>
                        </form>
                    </div>
                    <!-- BEGIN RESULTS DISPLAY -->
                    <div class="content result">
                        <div class="container">
                            <h3>Upload Results:</h3>
                            <pre class="output">
                                <?php
                                if($_UPLOADS !== null)
                                {
                                    foreach($_RESULTS as $res) {
                                        echo $res;
                                    }
                                }
                                else
                                {
                                    echo "Nothing uploaded yet!";
                                }
                                ?>
                            </pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN CONTENT FOOT -->
            <div class="content foot">
                <div class="social-links">
                    <p><i class="icon-social-github"></i> github <a href="https://github.com/yatesm4">@yatesm4</a>&nbsp;&nbsp;|&nbsp;&nbsp;</p>
                    <p><i class="icon-game-controller"></i> itch.io <a href="https://yesterdaydev.itch.io">@yesterdaydev</a>&nbsp;&nbsp;|&nbsp;&nbsp;</p>
                    <p><i class="icon-social-twitter"></i> twitter <a href="https://twitter.com/yesterdaydev">@yesterdaydev</a></p>
                </div>
            </div>

        </div>
    </body>
</html>
<!-- END HTML DOC -->