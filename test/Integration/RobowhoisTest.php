<?php

/*
 * This file is part of the Robowhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) David Funaro <ing.davidino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class RobowhoisTest
 *
 * @package     Robowhois
 * @subpackage  Test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace test\Integration;

use test\TestCase;

class RobowhoisTest extends TestCase
{
    public function testIndexOfRobowhoisdotcom()
    {        
        $domain                 = "robowhois.com";
        $index                  = $this->getWebService()->whoisIndex($domain);

        //$this->assertEquals($index->getContent(),  StubClient::getContent($domain));
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
}

