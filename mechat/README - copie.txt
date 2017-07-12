## INSTALLER:

1. Extract the meChat folder in the root of your site. 
Example: www.yoursite.com/mechat 


2. Open in your browser "mechat/manager/index.php".
Example: www.yoursite.com/mechat/manager/index.php


3. Login with the default password "123456".


4. Open in your browser "mechat/manager/installer.php".
Example: www.yoursite.com/mechat/manager/installer.php


5. Change the password of manager in "mechat/manager/changepassword.php".
Example: www.yoursite.com/mechat/manager/changepassword.php


6. Ready! Add the following line of code on pages where you want the meChat appear. 
Examples:

<script src="mechat/php/js.php"></script> --------------- www.yoursite.com/index.php    
<script src="../mechat/php/js.php"></script> ------------ www.yoursite.com/example/index.php

IMPORTANT: Add the script tag in the <body> or <html>, after the jQuery script load.
IMPORTANT: Open the meChat Manager to check if is working.


[---------------------------------------------------------------------------------------------------------------------------]

## MANUAL INSTALLATION:

1. Extract the meChat folder in the root of your site. 
Example: www.yoursite.com/mechat 


2. Create a database with the name of your choice. 


3. Run the query "SQL.sql" found in the root folder of meChat in the database created.
Example: www.yoursite.com/mechat/SQL.sql
 

4. Set the database, image upload, and style of the meChat in the file "config.json" found in the "php" folder, which is located at the root of meChat. 
Example: www.yoursite.com/mechat/config.json 


5. Then open the manager of the meChat in your browser, this is located in the "manager" folder at the root of meChat. 
Check if everything is right, the default password is "123456".
Example: www.yoursite.com/mechat/manager/index.php


6. Ready! Add the following line of code on pages where you want the meChat appear. 
Examples:

<script src="mechat/php/js.php"></script> --------------- www.yoursite.com/index.php    
<script src="../mechat/php/js.php"></script> ------------ www.yoursite.com/example/index.php

IMPORTANT: Add the script tag in the <body> or <html>, after the jQuery script load.
IMPORTANT: Open the meChat Manager to check if is working.
IMPORTANT: Do not forget to create a database with the name of your preference and execute SQL query found in "mechat/SQL.sql" file.

