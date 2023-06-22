![wordpress](https://img.shields.io/badge/wordpress-v6.2-0678BE.svg?style=flat-square)
![php](https://img.shields.io/badge/PHP-v8.1-828cb7.svg?style=flat-square)
![Node](https://img.shields.io/badge/node-v18-644D31.svg?style=flat-square)
![composer](https://img.shields.io/badge/composer-v2-126E75.svg?style=flat-square)

## ABOUT
An advanced blog Wordpres project about coding by [Noweh](https://github.com/noweh/) and [Rapkalin](https://github.com/Rapkalin/).

## HOW TO INSTALL THE PROJECT

### 1- BACKEND

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

# USED FOR DATABASE IMPORT SCRIPTS
PROD_HOST=
PROD_USER=
PROD_SITEURL=
DATABASE_PROD_HOST=
DATABASE_PROD_NAME=
DATABASE_PROD_USER=
DATABASE_PROD_PASSWORD=
```

4- Configure your vHost
- ServerName: explain-code.local 
- Directory: your-directory-name/website
```
  <VirtualHost *:80>
    ServerName explain-code.local
    DocumentRoot "/Users/r.kalinowski/Sites/explain-code/website"
    ServerAlias explain-code.local.*
    <Directory "/Users/r.kalinowski/Sites/explain-code/website">
      Options Includes FollowSymLinks
      AllowOverride All
    </Directory>
 </VirtualHost>
```

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

### 2- FRONTEND
- N/A

### 3- TRANSLATIONS
The explain-code.pot file is the website's base language 
- Download and open the free [poedit](https://poedit.net/) software
- Translation functions to use:
  - __: Translate
  - _e: Translate and displays
  - _n: Translate and displays the plural
  
#### ADD A NEW LANGUAGE
If the translation file doesn't exist in the language you want:
- Open the Poedit software
- Create a new file from the _explain-code.pot_ file to retrieve all words to translate
- Name it with the code needed code langage. Example: en_US

#### ADD A NEW WORD TO TRANSLATE
If you want to add a new word to translate:
- Open the _explain-code.pot_ file
- Go to the translate (or catalog) menu
- Click on update source code to retrieve all new translations added in the code

## MEANING OF SOME DIRECTORIES AND FILES

### WEBSITE/APP
This directory replace the wordpress-core/wp-content native Wordpress directory. 
This is where you will find all the plugins, themes etc:
- W3 Super Cache: this plugin install a few files and directories:
  - cache
  - w3tc-config
  - advanced-cache.php
- Languages: directory that handle the translations of your website. It is created by Wordpress when you configure the default language of your Wordpress website.
- Uploads: contains all the website's media files
- Plugins and themes: where are all the plugins & themes and custom plugins & themes/child-themes