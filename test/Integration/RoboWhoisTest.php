<?php

/*
 * This file is part of the RoboWhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * (c) David Funaro <ing.davidino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class RoboWhoisTest
 *
 * @package     RoboWhois
 * @subpackage  Test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace test\Integration;

use test\TestCase;
use RoboWhois\RoboWhois;
use Stub\Http\Client as StubClient;

class RoboWhoisTest extends TestCase
{
    public function testIndexOfRoboWhoisdotcom()
    {        
        $domain                 = "robowhois.com";
        $index                  = $this->getWebService()->whois($domain);

        $this->assertEquals($this->stripSpecials($index), $this->stripSpecials(StubClient::getContent($domain)));
    }

    public function testAccountInformation()
    {
        $account = $this->getWebService()->account();  
        $this->assertInstanceOf('RoboWhois\Account', $account);
    }

    /**
     * @expectedException RoboWhois\Exception
     */
    public function testIndexOfANonExistingDomain()
    {        
        $domain                 = "robowhois.com" . 123467;
        $index                  = $this->getWebService()->whois($domain);

        $this->assertInstanceOf('RoboWhois\Whois\Index', $index);
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testExecutingUnauthenticatedRequests()
    {        
        $domain                 = "robowhois.com";
        $robowhois              = new RoboWhois("...");
        $index                  = $robowhois->whois($domain);
        $this->assertEquals($this->stripSpecials($index->getContent()), $this->stripSpecials(StubClient::getContent($domain)));
        $this->assertInstanceOf('RoboWhois\Whois\Index', $index);
    }
    
    public function testDomainAvailability()
    {
        $availability = $this->getWebService()->whoisAvailability('robowhois.com');
        
        $this->assertFalse($availability['available']);
        $this->assertTrue($availability['registered']);
    }
    
    public function testDomainAvailabilityConvenientMethods()
    {        
        $this->assertFalse($this->getWebService()->isAvailable('robowhois.com'));
        $this->assertTrue($this->getWebService()->isRegistered('robowhois.com'));
    }
    
    public function testRecord()
    {
        $record = $this->getWebService()->whoisRecord('robowhois.com');

        $this->assertInstanceOf('RoboWhois\Whois\Record', $record);
    }
    
    public function testParts()
    {
        $record = $this->getWebService()->whoisParts('robowhois.com');

        $this->assertInstanceOf('RoboWhois\Whois\Parts', $record);
    }
    
    public function testProperties()
    {
        $record = $this->getWebService()->whoisProperties('robowhois.com');

        $this->assertInstanceOf('RoboWhois\Whois\Properties', $record);
    }

    protected function stripSpecials($content)
    {
        $pattern     = array(" ", "\r\n", "\n", "\r");
        $datePattern = '/>>>(.*)<<</';

    	return preg_replace($datePattern, '',str_replace($pattern, '', $content ));
    }
}

