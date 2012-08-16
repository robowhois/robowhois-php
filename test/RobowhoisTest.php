<?php

/*
 * This file is part of the RoboWhois package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class RoboWhoisTest
 *
 * @package     RoboWhois
 * @subpackage  test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */


use RoboWhois\RoboWhois;
use Stub\Http\Client;
use test\TestCase;

class RoboWhoisTest extends TestCase
{   
    public function testWhoisIndex()
    {
        $domain         = 'www.index.com';
        $filePath       = __DIR__.'/bin/'. $domain;
        $robowhois      = new RoboWhois("aaa", new Client);
        $index          = $robowhois->whois($domain);        
        $fileContents   = Client::getContent($domain);
        
        $this->assertEquals($fileContents, $index);
    }
    
    public function testWhoisRecord()
    {
        $domain     = 'www.index.com';
        $filePath   = __DIR__.'/bin/'. $domain;
        $robowhois  = new RoboWhois("aaa", new Client);
        $whois     = $robowhois->whoisRecord($domain);
        
        $this->assertEquals('2012-01-01', $whois['daystamp']);
        $this->assertEquals('MyRecord', $whois['record']);
        $this->assertInstanceOf('RoboWhois\Whois\Record', $whois);
    }
    
    /**
     * @expectedException RoboWhois\Exception 
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsWithAnInvalidApiKey()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $index      = $robowhois->whois('wrongapikey.com');      
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsToNonExistingAPIEndpoints()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('notfound.com'); 
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAnExceptionIsRaisedWhenABadgatewayErrorOccurs()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('502.com'); 
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAnExceptionIsRaisedWhenAnIntervalServerErrorOccurs()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('500.com'); 
    }

    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAnExceptionIsRaisedWhenVoidResponse()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('void.com'); 
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAGenericErrorRaisesABadRequestException()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('400.com'); 
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testAnUnknownErrorRaisesAGenericException()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whois('409.com');
    }

    public function testGetAccountInformation()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $account    = $robowhois->account();

        $this->assertInstanceOf('RoboWhois\Account', $account);
        $this->assertEquals('4ef12dbfca71cce5fd000001', $account['id']);
        $this->assertEquals('email@example.com', $account['email']);
        $this->assertEquals('0123456789', $account['api_token']);
        $this->assertEquals(480, $account['credits_remaining']);
        $this->assertEquals(480, $account->getCreditsRemaining());
    }
    
    /**
     * @expectedException RoboWhois\Exception
     */
    public function testDomainAvailabilityWithAMalformedResponse()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $robowhois->whoisAvailability('availablebutmalformed.com'); 
    }
    
    public function testADomainIsAvailable()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $availability = $robowhois->whoisAvailability('available.com'); 
        
        $this->assertTrue($availability['available']);
        $this->assertFalse($availability['registered']);
        $this->assertEquals('2012-01-01', $availability['daystamp']);
    }
    
    public function testAvailabilityConvenientMethods()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        
        $this->assertTrue($robowhois->isAvailable('available.com'));
        $this->assertFalse($robowhois->isRegistered('available.com'));
    }
    
    public function testWhoisProperties()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $domain     = $robowhois->whoisProperties('propertydomain.com');

        $this->assertEquals('2011-08-23', $domain['daystamp']);
        $this->assertInstanceOf('RoboWhois\ArrayObject', $domain->getProperties());
        $this->assertInstanceOf('RoboWhois\ArrayObject', $domain->getProperties()->getRegistrar());
    }
    
    public function testWhoisParts()
    {
        $robowhois  = new RoboWhois("aaa", new Client);
        $domain     = $robowhois->whoisParts('partsdomain.com');

        $this->assertEquals('2011-08-23', $domain['daystamp']);
        $this->assertInstanceOf('RoboWhois\ArrayObject', $domain->getParts());
        $this->assertNotEmpty($domain['parts'][0]['body']);
    }
}

