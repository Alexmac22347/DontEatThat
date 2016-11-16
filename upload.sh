#!/bin/bash

if [ "$1" == -r ]; then
    scp -r public_html/ group14@donteatthat.ca:~/
elif [ "$1" == -p ];  then
    scp public_html/*.* group14@donteatthat.ca:~/public_html/
    scp -r public_html/php/ group14@donteatthat.ca:~/public_html/
    scp -r public_html/classes/ group14@donteatthat.ca:~/public_html/
else
    scp public_html/*.* group14@donteatthat.ca:~/public_html/
fi
