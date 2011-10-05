# ImageBlog Manual and Setup Guide
This is the ImageBlog Manual and Setup Guide. This file contains usefull information about installing, configuring and using ImageBlog.
A demo of an ImageBlog installation can be found on http://www.galdo.de/imageblog/

## Installation
Installation is very easy. Just extract the archive into your PHP based web server - that's it. The ImageBlog archive contains all you need for starting your new and super fast photo blogging website. If anything fails during runtime - ImageBlog repairs itself using its internal configurationless routines.

ImageBlog itself consists of three files:

+ the main file of the site `index.php`
+ the admin file which is your place to create new entries `admin.php`
+ the ImageBlog Library `lib/imageblog-0.1.php`

Additionally there are more files to install concerning the template:

+ the template configuration `tpl/classic.conf.php`
+ the template itself defined in `tpl/classic.css`

If you want to use a secure admin area edit the htaccess and htpasswd files to your needs and rename them:

+ htaccess -> .htaccess
+ htpasswd -> .htpasswd

## Configuration
You have to set only four parameters to configure ImageBlog:

+  the title of your blog `$imageblog['title']`
+  the data path of your blog `$imageblog['data_path']`
+  the date format of your blog `$imageblog['date_format']`
+  the template (located within the tpl directory) `$imageblog['template']`

If you want to customize the default theme *classic* which is basically installed, just modify the templage configuration settings and store your own template-configuration and template-stylesheet within the ./tpl directory.

## APIs
ImageBlog supports remote posting of entries with HTTP POST requests. The request has to be sent to admin.php installed on your website. Fill the following data:

+ entry_title
+ entry_tags
+ entry_file

## Manual
Your ImageBlog installation runs well when the index site is loaded successfully. If you have any images and entries installed on your database (there is a demo database available here) you can directly see any images - otherwise no image - but the rest of the site is shown.

If you want to add an new blog entry to your ImageBlog installation just surf to the admin.php site (which is currently not secured), fill all the boxes and after a press on the "submit" button - you have created a new entry.

## Features to come

+ EXIF data handling presented in an image overlay
+ HTML configurable header and top level menu
+ RSS / ATOM feeds
+ Mobile Website