
<div align="center">
        <h1>monkeyshot</h1>
        <i>A simple image upload server.</i>
</div>
<br>

<p align="center">
        
</p>

Monkeyshot allows you to upload images to your server using `POST requests`.
The configuration file lets you configure the metatags sent when sharing the image.
This makes your embed look fancy when shared on social media sites.
There is a client allowing you to take and directly upload screenshots at [monkeyshot-client](https://github.com/elderguardian/monkeyshot-client).

## Preview of images shared on Discord

<img src="https://github.com/elderguardian/monkeyshot/assets/129489839/cc1715e5-3b88-4e24-b95f-3eab7aa36c8e" alt="Monkeyshot preview" height="200">
<img src="https://github.com/elderguardian/monkeyshot/assets/129489839/88415698-2923-4ce1-82ba-92399a8ef1e8" alt="Monkeyshot preview 2" height="200">

## Deployment

### Webserver
Create a webserver with PHP support and `git clone` the repository into its root directory.
Now redirect all requests except to `/static` to `index.html`.

### Redirecting on Apache
There is a `.htaccess` file in the repostiory.
Make sure your apache configuration allows them and it should work without problems.

### Redirecting on Nginx
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
