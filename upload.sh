#!/bin/bash

if [ "$1" == -r ]; then
    scp -r public_html/ group14@donteatthat.ca:~/
else
    scp public_html/*.* group14@donteatthat.ca:~/public_html/
fi
