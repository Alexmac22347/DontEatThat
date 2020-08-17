[![Build Status](https://travis-ci.com/Alexmac22347/DontEatThat.svg?token=Dp1JTmix1PPSSRxKqqsj&branch=master)](https://travis-ci.com/Alexmac22347/DontEatThat) <img src="public_html/res/greylogo.png" width="25%" height="25%" align="right"/>

# Don't Eat That Web Application

A web application that allows a user to be able to make healthier food choices. The inspiration for the development of Don't 
Eat That! was the book Eat This, Not That!, a nutrition guide that displays a handful of food products from every category 
and suggests the healthiest choice. We felt that the book did not have enough food products and did not allow users to make a 
side by side comparison of two choices. Hence, this web application is designed so users can compare two food products side by 
side and receive a recommendation.


## Getting Started

The files in public_html should be placed in a folder which is hosted
on the internet. We use a web host which was purchased from godaddy.com

Certain php scripts require Oath keys or MySQL username/password/database names.
These should be placed in a new file: config/config.php

Here is an example of a config.php file:
```
<?php

return array(
    'consumer_key' => 'fatsecret_consumer_key',
    'secret_key' => 'fatsecret_secret_key',
    'database_username' => 'mysql_username',
    'database_password' => 'mysql_password',
    'database_hostname' => 'mysql_hostname',
    'database_name' => 'mysql_database_name'
);

?>
```

DontEatThat! uses the [FatSecret Platform API](https://platform.fatsecret.com/api/) in order to retrieve
food data. The autocomplete functionality also requires the premier version of the API. After signing up for the
API, you should recieve a consumer key and a secret key. Place these in the config.php file as shown above.  

Also, DontEatThat! requires at least PHP 5.5 to run. This is because the function used to encrypt user passwords is only
available in PHP 5.5 and above.


## Hosting on Linux

Here's how to get the website running on localhost if you're a linux user.  
1. First, install [XAMPP](https://www.apachefriends.org/download.html)  
2. In order for the website to properly work, you must suppress some warnings. Edit the file /opt/lampp/etc/php.ini, and replace the line  
``` error_reporting=E_ALL & ~E_DEPRECATED & ~E_STRICT ```  
with  
``` error_reporting=E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR ```  
3. After installing, go to the folder /opt/lampp/htdocs  
4. Remove everything in the folder htdocs, and copy all all the files and folders in DontEatThat/public_html into htdocs  
5. Create a folder in /opt/lampp called config/  
6. place your config.php in the config/ folder you just created. Heres the config.php I use:  
```
<?php

return array(
    'consumer_key' => 'get your own consumer key',
    'secret_key' => 'get your own secret key',
    'database_username' => 'root',
    'database_password' => '',
    'database_hostname' => 'localhost',
    'database_name' => 'Group14DB'
);

?>

```

   Almost there! Now you need to setup the user database. 

7. In a web browser, go to the url 'localhost/phpmyadmin'  
8. Now, we have to create the user database  
  1. Create a new database called "Group14DB"  
  2. Create a new table in this database called "Users"  
  3. Go to the "Users" table, then click on the "Structures" tab  
  4. Add the following columns (case sensitive. Data type is shown in parentheses):  
    * Name (varchar(64))  
    * Username (varchar(64))  
    * Password (varchar(256))  
    * Calories (varchar(8))  
    * Sugar (varchar(8))  
    * Sodium (varchar(8))  
    * Protein (varchar(8))  
    * Calcium (varchar(8))  
10. Now, start the XAMPP Webserver:  
```
sudo /opt/lamp/xampp start
```
You're done! Check out the website by going to 'localhost' on your web browser.   


## Running Unit Tests

Unit tests are for testing the FatSecret API query, the comparison of two food items, and autocomplete.
They are run using Atoum. Make sure you have composer installed (https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
In the home directory, run:
```
composer install
```
Atoum should now be installed. To run the tests, run the following script:  

```
./scripts/runUnitTests.sh
```

## Running Database Tests

WARNING: If two instances of MySQL are running (for example, XAMPP is running MySQL), these tests will not work!
These tests are a little more complicated to setup. They involve creating/deleting accounts, and logging in/logging out.
First, install mysql-server
```
sudo apt-get install mysql-server
```
you may also need to install mysql for php:
```
sudo apt-get install php7.0-mysql
```
Change the config.php file so that the database username is "root", and
the database password is your sudo password. You could also create
a new mysql user and use that password/username combo in the config if you want.

Make sure mysql is running
```
sudo service mysql start
```

Create a database called 'Group14DB', and create a table called 'Users'.
Add the following columns to that table:
* Name (varchar(64))  
* Username (varchar(64))  
* Password (varchar(256))  
* Calories (varchar(8))  
* Sugar (varchar(8))  
* Sodium (varchar(8))  
* Protein (varchar(8))  
* Calcium (varchar(8))  

Hopefully you are ready to run the database test. Use the script:

```
./scripts/runDatabaseTests.sh
```


## Structure
All the source files are contained in "public_html".  
The php files inside public_html are actual webpages, which contain HTML and can be viewed.  
```classes/```  Contains php helper classes.  
```css/```  Contains mainstyle.css, which helps determine the "look" of the website.  
```js/```  Contains various javascript helper functions. These are used in the php webpages.  
```layout/```  Contains the header and footer, which are used in every php webpage.  
```php/```  Contains various php scripts.  
```res/```  Contains resources. Mostly images.  
```vendors/```  Contains javascript libraries. We just used Bootstrap.  


## Authors
Benny Lo - https://github.com/bennylojf  
Charn Rai - https://github.com/charnrai  
Alex Macdonald - https://github.com/Alexmac22347  
Adil Kydyrbayev - https://github.com/Adil9551  
Kenton Ma - https://github.com/KentonMa  
