INSTALL
-------

Edit "error.tpl" and change variable $showSourceUri (path to "showSource.php")
Include "prepend.php" at the beginning of your script.

FILES
-----

example1.html - example of displaying an error
example2.html - example of displaying source of the file where the error appeared

Handler.php - ErrorHandler class
showSource.php - show source of the file, highlights the line where the error appeared
error.tpl - template for displaying errors