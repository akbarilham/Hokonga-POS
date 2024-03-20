# HOKONGA-PHP Sample Code
**[HOKONGA-PHP](https://github.com/hokonga/hokonga-php)** is a library for connecting with Hokonga Payment Gateway services (see more https://docs.hokonga.co/).

All files in this directory will show you about the best pratices that you should do when implementing  **hokonga-php** into your project.

## Requirements
- PHP 8 and above.
- Built-in libcurl support.

## Installation
For running this example, you need to install `hokonga-php` library before. It can be done by two different methods:

### 1. Using Composer
You can install the library via [Composer](https://getcomposer.org/). If you don't already have Composer installed, first install it by following one of these instructions depends on your OS of choice:
* [Composer installation instruction for Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)
* [Composer installation instruction for Mac OS X and Linux](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

After composer is installed, Then run the following command to install the Hokonga-PHP library:

```
php composer.phar install
```

Please see configuration section below for configuring your Hokonga Keys.

### 2. Manually

If you're not using Composer, you can also clone `hokonga/hokonga-php` repository into the directory of sample code that you just installed this repository:

```
git clone https://github.com/hokonga/hokonga-php
```

However, using Composer is recommended as you can easily keep the library up-to-date. After cloning the repository, you need to replace line 3 in `config.php` from
```php
3: require_once 'vendor/autoload.php';
```

to

```php
3: require_once 'hokonga-php/lib/Hokonga.php';
```

Please see configuration section below for configuring your Hokonga Keys.

## Configuration
After you installed `hokonga-php` library already. Next, you need to **configure** your Hokonga Keys.  
So, we have 2 files that you need to change:
- `examples/php`/index.php
- `examples/php`/config.php 

### index.php
To collect a customer's card data and exchange for a [`token`](https://docs.hokonga.co/api/tokens/), you need to config your `Hokonga Key Public` in this file.  
On line 32 in this file, you will see something like below
```javascript
30: <script>
31:   // Set Hokonga Public Key (from hokonga.co > log in > Keys tab)
32:   Hokonga.setPublicKey("pkey_test");
33: </script>
```
change `pkey_test` to your [`Hokonga Public Key for Test`](https://docs.hokonga.co/api/authentication/)

### config.php
On line 6 - 7 in this file, you will see something like below.  
To use all features in Hokonga, you need to configure both your `Hokonga Key Public` and `Hokonga Key Secret` in this file. The secret key should be kept safe, it is used to make a full charge from a token or to create a permanent customer to charge later, also every other permanent action on your account.  
```php
5: /* Defined HOKONGA KEYS */
6: define('OMISE_PUBLIC_KEY', 'pkey_test');
7: define('OMISE_SECRET_KEY', 'skey_test');
```
change `pkey_test` to your [`Hokonga Public Key for Test`](https://docs.hokonga.co/api/authentication/),  
change `skey_test` to your [`Hokonga Secret Key for Test`](https://docs.hokonga.co/api/authentication/)


## Folder Structure
In this example, we have some files and folder that you need to concentrate about, as follows:
- `examples/php`/index.php
- `examples/php`/services/*

### index.php
This file will contains `html` and `javascript` code for **[collecting a customer's card and send it to Hokonga Server for tokenizing the card](https://docs.hokonga.co/collecting-card-information/) into a  [`token`](https://docs.hokonga.co/api/tokens/)**.

### services/*
This folder contains sample php files that include `hokonga-php` library. It will show you how to integrate `hokonga-php` library into your php file and use it.

## Usage
Run `index.php` in your browser.

## Tips
You are not allowed to send the card data to your servers.
