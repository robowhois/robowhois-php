<?php

/*
 * This file is part of the Robowhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Domain
 *
 * @package     Robowhois
 * @subpackage  test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\test;

use PHPUnit_Framework_TestCase;
use Robowhois\Client;
use Robowhois\Domain;
use Buzz\Browser;

class DomainTest extends PHPUnit_Framework_TestCase
{
  public function setup()
  {
    $this->token = file_get_contents("test/.token");
  }
  
  public function testARegisteredDomain()
  {
    $robowhois  = new Client(new Browser(), $this->token);
    $domain     = new Domain("google.com");
    $robowhois->getAvailability($domain);
    
    $this->assertFalse($domain->isAvailable());
  }
}

