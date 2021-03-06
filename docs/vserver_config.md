update package archive

	sudo apt-get update

install required tools

	sudo apt install php5-cgi nginx vim


configure php-fastcgi start script:
	
	
	sudo vim /etc/init.d/php-fastcgi
	
contents:

	#!/bin/bash
	BIND=/tmp/php-fastcgi.socket
	USER=www-data
	PHP_FCGI_CHILDREN=15
	PHP_FCGI_MAX_REQUESTS=1000

	PHP_CGI=/usr/bin/php-cgi
	PHP_CGI_NAME=`basename $PHP_CGI`
	PHP_CGI_ARGS="- USER=$USER PATH=/usr/bin PHP_FCGI_CHILDREN=$PHP_FCGI_CHILDREN PHP_FCGI_MAX_REQUESTS=$PHP_FCGI_MAX_REQUESTS $PHP_CGI -b $BIND"
	RETVAL=0

	start() {
		  echo -n "Starting PHP FastCGI: "
		  start-stop-daemon --quiet --start --background --chuid "$USER" --exec /usr/bin/env -- $PHP_CGI_ARGS
		  RETVAL=$?
		  echo "$PHP_CGI_NAME."
	}
	stop() {
		  echo -n "Stopping PHP FastCGI: "
		  killall -q -w -u $USER $PHP_CGI
		  RETVAL=$?
		  echo "$PHP_CGI_NAME."
	}

	case "$1" in
		start)
		  start
	  ;;
		stop)
		  stop
	  ;;
		restart)
		  stop
		  start
	  ;;
		*)
		  echo "Usage: php-fastcgi {start|stop|restart}"
		  exit 1
	  ;;
	esac
	exit $RETVAL


Make executable, set as autostart, start:

	chmod +x /etc/init.d/php-fastcgi
	update-rc.d php-fastcgi defaults
	/etc/init.d/php-fastcgi start

Configure nginx:


	cd /etc/nginx/sites-enabled
	mv default peeeq.de

contents:

	server {
			listen   80 default;
			server_name  localhost;

			access_log  /var/log/nginx/localhost.access.log;

			root /var/www;

			location / {
					index  index.php index.html index.htm;
			}


			location ~ \.php$ {
				fastcgi_pass unix:/tmp/php-fastcgi.socket;
				fastcgi_index  index.php;
				fastcgi_param  SCRIPT_FILENAME  /var/www/$fastcgi_script_name;
				include        fastcgi_params;
			}



			# deny access to .htaccess files, if Apache's document root
			# concurs with nginx's one
			location ~ /\.ht {
					deny  all;
			}

			# expire headers:
			location ~* \.(ico|gif|jpg|jpeg|png|css|js)$ {
					expires max;
			}

			#for uploads
			location /uploaded/ {
					internal;
					root /var/www/uploads;
			}
	#rewrites:

	rewrite ^/uploads/([^\?&]*)$ upload.php?path=$1 last;
	rewrite ^/uploaddata/(.*)$ /uploads/$1 last;

	#rewrite ^/uploads/([^&]*)&(.*)$ upload.php?path=$1&$2 last;

	rewrite ^/download([0123456789]*)\.jpg$ download.php?id=$1 last;

	rewrite ^/zeichnung([0123456789]*)\.jpg$ svg2jpg.php?id=$1 last;
	rewrite ^/graph([0123456789]*)\.png$ graph.php?id=$1 last;


	rewrite ^/photos.rss$ media.php last;

	#rewrite ^/index.php$ /blog/ permanent;
	#rewrite ^/$ /blog/ permanent;
	rewrite ^/blog/$ / permanent;
	#rewrite ^/blog/wp-(.*)$ /blog/wp-$1 last;
	#rewrite ^/blog/p/([a-zA-Z0-9\-_/]+)$ /blog/index.php?p/$1 last;
	rewrite ^/p/(.+)$ /blog/index.php?p/$1 last;
	rewrite ^/feed/ /blog/index.php?feed/ last;
	rewrite ^/comments/ /blog/index.php?comments/feed/ last;
	}


Start nginx:

	/etc/init.d/nginx start

Install mysql:

	apt-get install mysql-server

Create dump on old server:

	mysqldump -u root --password -all-databases

install uncomplicated fire wall: 


	apt-get install ufw
	# allow ssh and http:
	ufw allow 22
	ufw allow 80
	ufw enable


# other tools:
lynx, wget, vim, sudo

