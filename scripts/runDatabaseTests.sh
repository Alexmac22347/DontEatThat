#!/bin/bash
# Run this script from the main DontEatThat directory

# I have to do this or config.php wont be found
cd public_html/php

# The order of the tests matters
php ../../tests/MakeAccountTest.php
php ../../tests/LoginTest.php
php ../../tests/DeleteAccountTest.php
