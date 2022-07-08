

Run in terminal composer install

Change information in config.php for your account


Your server need SSL certificate:

if you use OpenServer for windows it's already have SSL 

if you use Apache you should install it on your server

or

Save this certificate (https://curl.haxx.se/ca/cacert.pem) as cacert.pem in "Your_path"

Add to php.ini:

curl.cainfo = "Your_path\cacert.pem"

openssl.cafile="Your_path\cacert.pem"

You can run server by terminal 

php -S localhost:8000




Classes - folder with all classes 

index.php - its main file

post.php - for use form at main page. 

index.phtml - html code 



uploads folder contains all result files

