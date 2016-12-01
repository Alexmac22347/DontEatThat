#!/bin/bash
# Run this script from the main DontEatThat directory

if [ "$1" == -r ]; then
    scp -r public_html/ group14@donteatthat.ca:~/
elif [ "$1" == -p ];  then
    scp public_html/*.* group14@donteatthat.ca:~/public_html/
    scp public_html/php/* group14@donteatthat.ca:~/public_html/php/
    scp public_html/classes/* group14@donteatthat.ca:~/public_html/classes/
    scp public_html/layout/* group14@donteatthat.ca:~/public_html/classes/
elif [ "$1" == -j ];  then
    scp public_html/js/*.* group14@donteatthat.ca:~/public_html/js/
else
    scp public_html/*.* group14@donteatthat.ca:~/public_html/
fi
