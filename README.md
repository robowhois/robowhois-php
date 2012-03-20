# PHP client for Robowhois APIs

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

then you can use Robowhois in your code: bare in mind that the autoloading follows the
[PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
standard: there is an auto-generated autoloader that you can use:

    require 'vendor/.composer/autoload.php';

## Consuming the account API

The *account* API is supposed to return informations about the account which is
making requests to the Robowhois webservice:

    <?php

    use Robowhois\Robowhois;
    use Robowhois\Exception;

    require 'vendor/.composer/autoload.php';

    $robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

    try {
        $account =  $robowhois->whoisAccount();

        echo $account->getCreditsRemaining();
    } catch (Exception $e) {
        echo "The following error occurred: " . $e->getMessage();
    }

Take a look at the `Robowhois\Account` class to understand which attributes
are available from the API.

You can take a look at the `sample/account.php` script provided inside this
repository, or run it

    php sample/account.php

## Consuming the index API

The *index* API is supposed to return raw text/plain WHOIS records:

    <?php

    use Robowhois\Robowhois;
    use Robowhois\Exception;

    require 'vendor/.composer/autoload.php';

    $robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

    try {
        echo $robowhois->whoisIndex('robowhois.com')->getContent();
    } catch (Exception $e) {
        echo "The following error occurred: " . $e->getMessage();
    }

You can take a look at the `sample/index.php` script provided inside this
repository, or run it

    php sample/index.php

## Consuming the record API

The *record* API is supposed to return a JSON representation of the *index* one:

    <?php

    use Robowhois\Robowhois;
    use Robowhois\Exception;

    require 'vendor/.composer/autoload.php';

    $robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

    try {
        echo $robowhois->whoisRecord('robowhois.com')->getRecord();
        echo $robowhois->whoisRecord('robowhois.com')->getDaystamp();
    } catch (Exception $e) {
        echo "The following error occurred: " . $e->getMessage();
    }

Using `IndexAPI::getContent()` and `RecordAPI::getRecord()` should be the same
thing.

You can take a look at the `sample/record.php` script provided inside this
repository, or run it

    php sample/record.php

## Consuming the availability API

The *availability* API is supposed to give a feedback about the registration of
a particular domain:

    <?php

    use Robowhois\Robowhois;
    use Robowhois\Exception;

    require 'vendor/.composer/autoload.php';

    $robowhois = new Robowhois('INSERT-YOUR-API-KEY-HERE');

    try {
        $domains = array(
        'google.com', 'mycustomabsurddomainnamenooneeverregistered.ch'
        );

        foreach ($domains as $domain) {
            $availability = $robowhois->whoisAvailability($domain);

            if ($availability['available']) {
                echo sprintf("%s is available!", $domain) . "\n";
            } else {
                echo sprintf("%s is registered!", $domain) . "\n";
            } 
        }
    } catch (Exception $e) {
        echo "The following error occurred: " . $e->getMessage();
    }

There are a couple convenient methods to quickly check a domain's availability:
you can use `$robowhois->isAvailable($domain)` and
`$robowhois->isRegistered($domain)`.

You can take a look at the `sample/availability.php` script provided inside this
repository, or run it

    php sample/availability.php

## PHPDoc

You can generate PHP documentation with doxygen:

    doxygen docs/.dox

## Test

The client is tested with phpunit; you can run the tests, from the repository's
root, by doing:

    phpunit

Some tests require internet connection (to test against a real API response),
so they are disabled by default; to run them add a `.token` file under the `test`
directory containing your Robowhois API key and run

    phpunit test/

## Thanks to

* [Simone Carletti](http://www.simonecarletti.com/)
* [Alessandro Nadalin](http://www.odino.org)
* [David Funaro](http://davidfunaro.com)