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
use Robowhois\Robowhois;
use Stub\Http\Client as StubClient;

class RobowhoisTest extends TestCase
{
    public function testIndexOfRobowhoisdotcom()
    {        
        $domain                 = "robowhois.com";
        $index                  = $this->getWebService()->whoisIndex($domain);

        $this->assertEquals($this->stripSpecials($index->getContent()),  $this->stripSpecials(StubClient::getContent($domain)));
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Request\Unauthorized 
     */
    public function testExecutingUnauthenticatedRequests()
    {        
        $domain                 = "robowhois.com";
        $robowhois              = new Robowhois("...");
        $index                  = $robowhois->whoisIndex($domain);
        $this->assertEquals($this->stripSpecials($index->getContent()), $this->stripSpecials(StubClient::getContent($domain)));
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }

    private function stripSpecials($content)
    {
        $pattern     = array(" ", "\r\n", "\n", "\r");
        $datePattern = '/>>>(.*)<<</';

    	return preg_replace($datePattern, '',str_replace($pattern, '', $content ));
    }
}

