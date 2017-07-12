In the file "config.json" in the parent folder of the meChat, you can change 
the strings, colors and meChat settings...

However, this only takes effect if you use the file "js.php" instead of 
"mechat.js", because it will generate the <script> meChat with the 
assigned settings.

Example (in the site root): <script src="mechat/php/js.php"></script>

With the use of "js.php" there is no need to load stylesheets separately, 
only do it if you want to load a custom template created by you.