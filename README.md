[![Build Status](https://travis-ci.com/Alexmac22347/DontEatThat.svg?token=Dp1JTmix1PPSSRxKqqsj&branch=master)](https://travis-ci.com/Alexmac22347/DontEatThat)

# Don't Eat That Web Application

A web application that allows a user to be able to make healthier food choices. The inspiration for the development of Don't 
Eat That! was the book Eat This, Not That!, a nutrition guide that displays a handful of food products from every category 
and suggests the healthiest choice. We felt that the book did not have enough food products and did not allow users to make a 
side by side comparison of two choices. Hence, this web application is designed so users can compare two food products side by 
side and receive a recommendation.

## Getting Started

The files in public_html should be placed in a folder which is to be hosted
on the internet. We use a web host which was purchased from godaddy.com

Certain php scripts require Oath keys or MySQL username/password/database names.
These can be placed in a file: config/config.php

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

Also, DontEatThat! requires at least PHP 5.5 to run. This is because the function used to encrypt user passwords is only
available in PHP 5.5 and above.

```

## Running Tests
(WIP)
Tests are run using phpunit. To run all tests, first install phpunit. Make sure you are in 
the main directory. Then, use the following command:
```
phpunit tests/*
```

## Authors
Benny Lo - https://github.com/blo2569  
Charn Rai - https://github.com/charnrai  
Alex Macdonald - https://github.com/Alexmac22347  
Adil Kydyrbayev - https://github.com/Adil9551  
Kenton Ma - https://github.com/KentonMa  
