# PHP client for RoboWhois APIs

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

then you can use RoboWhois in your code: bare in mind that the autoloading follows the
[PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
standard: there is an auto-generated autoloader that you can use:

    require 'vendor/autoload.php';

## A brief note on the docs

We try to provide an efficient way to document the features of this client, but
bare in mind that, given RoboWhois API can change, this doc may be updated
(last revision: 08/16/2012): we strongly recommend to take a look at the
[tests](https://github.com/robowhois/robowhois-php/tree/master/test)
provided by this library as they are the simplest way to get in touch with
the working code.

## Objects as array

RoboWhois objects extend the class `RoboWhois\ArrayObject`, used to provide
a set of convenient methods for accessing data returned by the API.

Thanks to this class you are able to access objects' properties as arrays'
ones:

    $account = $robowhois->account();

    // $account is an instance of RoboWhois\Account
    echo $account['credits_remaining'];

and you can also rely on magic methods to convert those indexes in getters:

    echo $account->getCreditsRemaining();

## Consuming the account API

The *account* API is supposed to return informations about the account which is
making requests to the RoboWhois webservice:

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $account =  $robowhois->account();

    echo $account->getCreditsRemaining();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}
```

Take a look at the `RoboWhois\Account` class to understand which attributes
are available from the API.

You can take a look at the `sample/account.php` script provided inside this
repository, or run it

    php sample/account.php

## Consuming the index API

The *index* API is supposed to return raw text/plain WHOIS records:

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    echo $robowhois->whois('robowhois.com');
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}
```

You can take a look at the `sample/index.php` script provided inside this
repository, or run it

    php sample/index.php

## Consuming the record API

The *record* API is supposed to return a JSON representation of the *index* one:

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $whois = $robowhois->whoisRecord('robowhois.com');

    echo $whois['daystamp'] . "\n";
    echo $whois->getRecord();
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}
```

You can take a look at the `sample/record.php` script provided inside this
repository, or run it

    php sample/record.php

## Consuming the properties API

The *properties* API is supposed to return the parsed WHOIS record for a
domain:

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domain = $robowhois->whoisProperties('robowhois.com');

    echo $domain['properties']['created_on'] . "\n";
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}
```

You can take a look at the `sample/properties.php` script provided inside this
repository, or run it

    php sample/properties.php

## Consuming the parts API

The *parts* API is supposed to return  the WHOIS record for a domain without
merging the one or more responses returned by the contacted WHOIS server(s):

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

try {
    $domain = $robowhois->whoisParts('robowhois.com');

    echo $domain['parts'][0]['body'] . "\n";
} catch (Exception $e) {
    echo "The following error occurred: " . $e->getMessage();
}
```

You can take a look at the `sample/parts.php` script provided inside this
repository, or run it

    php sample/parts.php

## Consuming the availability API

The *availability* API is supposed to give a feedback about the registration of
a particular domain:

``` php
<?php

use RoboWhois\RoboWhois;
use RoboWhois\Exception;

require 'vendor/autoload.php';

$robowhois = new RoboWhois('INSERT-YOUR-API-KEY-HERE');

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
```

There are a couple convenient methods to quickly check a domain's availability:
you can use `$robowhois->whoisAvailability($domain)` and
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
directory containing your RoboWhois API key and run

    phpunit test/

## Thanks to

* [Simone Carletti](http://www.simonecarletti.com/)
* [Alessandro Nadalin](http://www.odino.org)
* [David Funaro](http://davidfunaro.com)
