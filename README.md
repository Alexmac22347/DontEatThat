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
2. After installing, go to the folder /opt/lampp/htdocs  
3. Remove everything in the folder htdocs, and copy all all the files and folders in DontEatThat/public_html into htdocs  
4. Create a folder in /opt/lampp called config/  
5. place your config.php in the config/ folder you just created. Heres the config.php I use:  
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

6. In a web browser, go to the url 'localhost/phpmyadmin'  
7. Now, we have to create the user database  
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
9. Now, start the XAMPP Webserver:  
```
sudo /opt/lamp/xampp start
```
You're done! Check out the website by going to 'localhost' on your web browser.   



## Running Tests
Tests are run using Atoum. Make sure you have composer installed (https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
In the home directory, run:
```
composer install
```
Atoum should now be installed. To run the tests, use the following command:  

```
php tests/*
```

## Authors
Benny Lo - https://github.com/blo2569  
Charn Rai - https://github.com/charnrai  
Alex Macdonald - https://github.com/Alexmac22347  
Adil Kydyrbayev - https://github.com/Adil9551  
Kenton Ma - https://github.com/KentonMa  
