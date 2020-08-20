<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">FTP Client for Yii 2</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yii2mod/yii2-ftp/v/stable)](https://packagist.org/packages/yii2mod/yii2-ftp) [![Total Downloads](https://poser.pugx.org/yii2mod/yii2-ftp/downloads)](https://packagist.org/packages/yii2mod/yii2-ftp) [![License](https://poser.pugx.org/yii2mod/yii2-ftp/license)](https://packagist.org/packages/yii2mod/yii2-ftp)

> yii2-ftp is a fork of [Nicolab/php-ftp-client](https://github.com/Nicolab/php-ftp-client) v1.2.0

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2mod/yii2-ftp "*"
```

or add

```
"yii2mod/yii2-ftp": "*"
```

to the require section of your composer.json.


## Getting Started

### Configuration in config/main.php

```php
    'components' => [
        ...
        'ftp'         => [
            'class'     => \yii2mod\ftp\components\FtpClient::class,
            'host'      => 'ftp.site.com',
            'user'      => 'root',
            'password'  => '123',
            'port'      => 21,
            'ssl'       => true,
            'passive'   => true,
            'timeout'   => 90,
        ],
        ...
    ];
```

Connect to a server FTP :

```php
    $ftp = \Yii::$app->ftp->connect();
```

Note: The connection is implicitly closed at the end of script execution (when the object is destroyed). Therefore it is unnecessary to call `$ftp->close()`, except for an explicit re-connection.


### Usage

Upload all files and all directories is easy :

```php
// upload with the BINARY mode
$ftp->putAll($source_directory, $target_directory);

// Is equal to
$ftp->putAll($source_directory, $target_directory, FTP_BINARY);

// or upload with the ASCII mode
$ftp->putAll($source_directory, $target_directory, FTP_ASCII);
```

*Note : FTP_ASCII and FTP_BINARY are predefined PHP internal constants.*

Get a directory size :

```php
// size of the current directory
$size = $ftp->dirSize();

// size of a given directory
$size = $ftp->dirSize('/path/of/directory');
```

Count the items in a directory :

```php
// count in the current directory
$total = $ftp->count();

// count in a given directory
$total = $ftp->count('/path/of/directory');

// count only the "files" in the current directory
$total_file = $ftp->count('.', 'file');

// count only the "files" in a given directory
$total_file = $ftp->count('/path/of/directory', 'file');

// count only the "directories" in a given directory
$total_dir = $ftp->count('/path/of/directory', 'directory');

// count only the "symbolic links" in a given directory
$total_link = $ftp->count('/path/of/directory', 'link');
```

Detailed list of all files and directories :

```php
// scan the current directory and returns the details of each item
$items = $ftp->scanDir();

// scan the current directory (recursive) and returns the details of each item
var_dump($ftp->scanDir('.', true));
```

Result:

	'directory#www' =>
	    array (size=10)
	      'permissions' => string 'drwx---r-x' (length=10)
	      'number'      => string '3' (length=1)
	      'owner'       => string '32385' (length=5)
	      'group'       => string 'users' (length=5)
	      'size'        => string '5' (length=1)
	      'month'       => string 'Nov' (length=3)
	      'day'         => string '24' (length=2)
	      'time'        => string '17:25' (length=5)
	      'name'        => string 'www' (length=3)
	      'type'        => string 'directory' (length=9)

	  'link#www/index.html' =>
	    array (size=11)
	      'permissions' => string 'lrwxrwxrwx' (length=10)
	      'number'      => string '1' (length=1)
	      'owner'       => string '0' (length=1)
	      'group'       => string 'users' (length=5)
	      'size'        => string '38' (length=2)
	      'month'       => string 'Nov' (length=3)
	      'day'         => string '16' (length=2)
	      'time'        => string '14:57' (length=5)
	      'name'        => string 'index.html' (length=10)
	      'type'        => string 'link' (length=4)
	      'target'      => string '/var/www/shared/index.html' (length=26)

	'file#www/README' =>
	    array (size=10)
	      'permissions' => string '-rw----r--' (length=10)
	      'number'      => string '1' (length=1)
	      'owner'       => string '32385' (length=5)
	      'group'       => string 'users' (length=5)
	      'size'        => string '0' (length=1)
	      'month'       => string 'Nov' (length=3)
	      'day'         => string '24' (length=2)
	      'time'        => string '17:25' (length=5)
	      'name'        => string 'README' (length=6)
	      'type'        => string 'file' (length=4)


All FTP PHP functions are supported and some improved :

```php
// Requests execution of a command on the FTP server
$ftp->exec($command);

// Turns passive mode on or off
$ftp->pasv(true);

// Set permissions on a file via FTP
$ftp->chmod('0777', 'file.php');

// Removes a directory
$ftp->rmdir('path/of/directory/to/remove');

// Removes a directory (recursive)
$ftp->rmdir('path/of/directory/to/remove', true);

// Creates a directory
$ftp->mkdir('path/of/directory/to/create');

// Creates a directory (recursive),
// creates automaticaly the sub directory if not exist
$ftp->mkdir('path/of/directory/to/create', true);

// and more ...
```

Get the help information of remote FTP server :

```php
var_dump($ftp->help());
```

Result :

	array (size=6)
	  0 => string '214-The following SITE commands are recognized' (length=46)
	  1 => string ' ALIAS' (length=6)
	  2 => string ' CHMOD' (length=6)
	  3 => string ' IDLE' (length=5)
	  4 => string ' UTIME' (length=6)
	  5 => string '214 Pure-FTPd - http://pureftpd.org/' (length=36)


_Note : The result depend of FTP server._


## Support us

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/yii2mod). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.
