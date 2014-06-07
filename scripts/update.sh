#!/bin/sh
git fetch --all
git reset --hard origin/master
cp /home/jacob/programming/nhs-config.php /var/www/bvswnhs.subd.in/php/config.php