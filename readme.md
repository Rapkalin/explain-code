![wordpress](https://img.shields.io/badge/wordpress-v6.2-0678BE.svg?style=flat-square)
![php](https://img.shields.io/badge/PHP-v8.1-828cb7.svg?style=flat-square)
![Node](https://img.shields.io/badge/node-v18-644D31.svg?style=flat-square)
![composer](https://img.shields.io/badge/composer-v2-126E75.svg?style=flat-square)

## ABOUT
An advanced blog Wordpres project about coding by [Noweh](https://github.com/noweh/) and [Rapkalin](https://github.com/Rapkalin/).

## HOW TO INSTALL THE PROJECT

### BACKEND

1- Create the directory on your computer
```
mkdir your-directory-name
```

2- Clone the website project from your directory:
```git
git clone git@github.com:Rapkalin/explain-code.git .
```

3- Move to the project directory and install the backend dependencies:
- cd your-directory-name
- composer install

3- Copy the .env.sample file, rename it to .env and complete the needed variables:
```
DATABASE_NAME='your-database-name'
DATABASE_USER='your-database-username'
DATABASE_PASSWORD='your-database-password'
DATABASE_HOST='your-host'

WP_ENV=local
WP_CONTENT_URL=http://explain-code.local/
WP_SITEURL=http://explain-code.local/
```

4- Configure your vHost
- ServerName: explain-code.local 
- Directory: your-directory-name/website

5- Import prod database
```
cd your-directory-name
php scripts/import-db.php
```

6- Import the uploads directory from prod to local
```
cd your-directory-name
php scripts/sync-uploads.php
```

### FRONTEND
- N/A

## MEANING OF SOME DIRECTORIES AND FILES

### WEBSITE/APP
- W3 Super Cache: this plugin install a few files and directories:
    - cache
    - w3tc-config
    - advanced-cache.php
- Languages: directory that handle the translation of your website. It is created by Wordpress when you configure the default language of your Wordpress website.
- Uploads: contains all the website's media files

### TRANSLATIONS
The explain-code.pot file is the website's base language 
To add translation:
- Download and open the [poedit](https://poedit.net/) software
- If the translation file doesn't exist in the language you want, create it with the poedit software
- Translation functions to use:
  - _e: displays the translation
  - _n: displays the plural