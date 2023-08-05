# monkeyshot

Monkeyshot allows you to upload images to your server using `POST requests`.
The configuration file lets you configure the metatags sent when sharing the image.
This makes your embed look fancy when shared on social media sites.
There is a client allowing you to take and directly upload screenshots at [monkeyshot-client](https://github.com/elderguardian/monkeyshot-client).

<img alt="Preview Image" width="300" src="https://github.com/elderguardian/monkeyshot/assets/129489839/32e3b31a-0641-449b-a289-37676716689d">

## Deployment

### Docker

Copy the `config.php` from the repository into a new directory and create a `docker-compose.yml`:

```
services:
  monkeyshot:
    image: ghcr.io/elderguardian/monkeyshot:latest
    ports:
      - 3000:80
    volumes:
      - ./config.php:/var/www/html/config.php
```

> **_NOTE:_** If you want to keep the images on a container restart, copy and volume the `static/` directory.

### Webserver
Create a webserver with PHP support and `git clone` the repository into its root directory.
Now redirect all requests except `/static` to `index.html`.

#### Redirecting on Apache
There is a `.htaccess` file in the repostiory.
Make sure your apache configuration allows them and it should work without problems.

#### Redirecting on Nginx
Redirecting on NGINX requires configuration in `/etc/nginx/sites-enabled/`.
Here is an example configuration.

```
server {
        server_name ms.example.com;
        root /path/to/ms ;
        index index.php;

        location /static/ {
                root /var/www/ms/ ;
                try_files $uri $uri/ index.html ;
        }

        location / {
                rewrite /?(.*)$ /index.php?path=$1 last;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        }
}
```

## Configuration
Edit the example `config.php` file inside the repository. You can use `$fileName` and `$fileSizeMb` inside the embed title and description. These variables will be replaced with the name or size of the file.
