# Install
- Step 1 : Setup gitbash with URL : 
https://git-scm.com/downloads
- Step 2 : Run gitbash and create your key for App with command : openssl genrsa -out $KEYNAME-private.key 2048 && openssl rsa -in $KEYNAME-private.key -outform PEM -pubout -out $KEYNAME-public.pem
- Step 3 : After create your key, clone app from git : git@github.com:quangnh94/app.git or download zip file : https://github.com/quangnh94/app/archive/master.zip
- Step 4 : Set up xampp : https://www.apachefriends.org/download.html. Move your folder clone from git to folder htdocs in xampp, start apache and mysql.
- Step 5 : Run localhost/phpmyadmin, create 1 db and import database file app.sql.
# Run App
- Step 1 : Go to config.php setup enviroment for your app, put your code key your create in Install step 2 to PrivateKey and PublicKey.
One Client has 2 key is PublicKey and PrivateKey.
Setup enviroment database username,password,databasename.
- Step 2 : Run App - Enjoy.
