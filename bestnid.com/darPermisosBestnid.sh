#!/bin/bash

if [ -d /opt/lampp/htdocs/bestnid.com ]; then
	sudo chown $USER:$USER /opt/lampp/htdocs/bestnid.com -R
	sudo chmod 777 /opt/lampp/htdocs/bestnid.com -R
	echo "Permisos dados en /opt/lampp/htdocs/bestnid.com correctamente."
	sleep 3
else
	sudo chown $USER:$USER /var/www/html/bestnid.com -R
	sudo chmod 777 /var/www/html/bestnid.com -R
	echo "Permisos dados en /var/www/html/bestnid.com correctamente."
	sleep 3
fi
