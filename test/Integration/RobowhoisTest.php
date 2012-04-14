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
        $index                  = $this->getWebService()->whois($domain);

        $this->assertEquals($this->stripSpecials($index->getContent()),  $this->stripSpecials(StubClient::getContent($domain)));
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }

    public function testAccountInformation()
    {
        $account = $this->getWebService()->account();  
        $this->assertInstanceOf('Robowhois\Account', $account);
    }

    /**
     * @expectedException Robowhois\Exception
     */
    public function testIndexOfANonExistingDomain()
    {        
        $domain                 = "robowhois.com" . 123467;
        $index                  = $this->getWebService()->whois($domain);

        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testExecutingUnauthenticatedRequests()
    {        
        $domain                 = "robowhois.com";
        $robowhois              = new Robowhois("...");
        $index                  = $robowhois->whois($domain);
        $this->assertEquals($this->stripSpecials($index->getContent()), $this->stripSpecials(StubClient::getContent($domain)));
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
    
    public function testDomainAvailability()
    {
        $availability = $this->getWebService()->domainAvailability('robowhois.com');
        
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

        $this->assertInstanceOf('Robowhois\Whois\Record', $record);
    }

    protected function stripSpecials($content)
    {
        $pattern     = array(" ", "\r\n", "\n", "\r");
        $datePattern = '/>>>(.*)<<</';

    	return preg_replace($datePattern, '',str_replace($pattern, '', $content ));
    }
}

