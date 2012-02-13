# PHP SDK for Robowhois APIs

## Installation

The easiest way to install the client is to use [Packagist](http://packagist.org/)
and [Composer](http://packagist.org/about-composer), the brand new package
manager for PHP >= 5.3.

Clone this repository wherever you want

    git clone git@github.com:robowhois/robowhois-php-client.git

download composer in the cloned directory

    wget http://getcomposer.org/composer.phar

and install the needed packages

    php composer.phar install

then you Robowhois in your code: bare in mind that the autoloading follows the
[PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
standard: there is an auto-generated autoloader that you can use:

    require 'vendor/.composer/autoload.php';

## Consuming the index API

The *index* API is supposed to return raw text/plain WHOIS records:

    <?php

    use Robowhois\Robowhois;
    use Robowhois\Exception;

    require 'vendor/.composer/autoload.php';

    $robowhois = new Robowhois('custom-robowhois-phpclient');

    try
    {
        echo $robowhois->whoisIndex('robowhois.com')->getContent();
    }
    catch (Exception $e)
    {
        echo "The following error occurred: " . $e->getMessage();
    }

You can take a look at the `sample/index.php` script provided inside this
repository, or run it

    php sample/index.php

## Test

The client is tested with phpunit; you can run the tests, from the repository's
root, by doing:

    phpunit

Some tests require internet connection (to test against a real API response),
so they are disabled by default; to run them add a `.token` file under the `test`
directory containing your Robowhois API key and run

    phpunit test/

## Thanks to

* [Simone Carletti](http://simone.carletti.name)
* [Alessandro Nadalin](http://www.odino.org)
* [David Funaro](http://davidfunaro.com)