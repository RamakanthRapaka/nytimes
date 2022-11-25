# nytimes
New York Times

# you will need to make sure your server meets the following requirements:
PHP >= 7.2.5
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension

# clone project
git clone <url>

# update composer
composer install
composer update

# run migration
php artisan migrate

# run application
php artisan serve

# Home Page
http://127.0.0.1:8000/

# Home Page View
![alt text](https://i.ibb.co/WDtWXZQ/screencapture-127-0-0-1-8000-2022-11-26-02-28-43.png)

# Load This Week Best Books And Lists Into DB For Grid
http://127.0.0.1:8000/api/bestseller

# Top Three Books From Latest Or Recent List
http://127.0.0.1:8000/api/topthreebooks

# Send Email With Top Books List Through API
http://127.0.0.1:8000/api/topthreebooksmail

# Send Email With Top Books List Through Command
php artisan top:books

# Get Book By ID
http://127.0.0.1:8000/api/getbookbyid

# Update Book By ID
http://127.0.0.1:8000/api/updatebookbyid