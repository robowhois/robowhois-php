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
 * Class RobowhoisTest
 *
 * @package     Robowhois
 * @subpackage  test
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */


use Robowhois\Robowhois;
use Stub\Http\Client;
use test\TestCase;

class RobowhoisTest extends TestCase
{   
    public function testWhoisIndex()
    {
        $domain         = 'www.index.com';
        $filePath       = __DIR__.'/bin/'. $domain;
        $robowhois      = new Robowhois("aaa", new Client);
        $index          = $robowhois->whois($domain);        
        $fileContents   = Client::getContent($domain);
        
        $this->assertEquals($fileContents, $index['content']);
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
    
    public function testWhoisRecord()
    {
        $domain     = 'www.index.com';
        $filePath   = __DIR__.'/bin/'. $domain;
        $robowhois  = new Robowhois("aaa", new Client);
        $whois     = $robowhois->whoisRecord($domain);
        
        $this->assertEquals('2012-01-01', $whois['daystamp']);
        $this->assertEquals('MyRecord', $whois['record']);
        $this->assertInstanceOf('Robowhois\Whois\Record', $whois);
    }
    
    /**
     * @expectedException Robowhois\Exception 
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsWithAnInvalidApiKey()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $index      = $robowhois->whois('wrongapikey.com');      
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsToNonExistingAPIEndpoints()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('notfound.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testAnExceptionIsRaisedWhenABadgatewayErrorOccurs()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('502.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testAnExceptionIsRaisedWhenAnIntervalServerErrorOccurs()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('500.com'); 
    }

    /**
     * @expectedException Robowhois\Exception
     */
    public function testAnExceptionIsRaisedWhenVoidResponse()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('void.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testAGenericErrorRaisesABadRequestException()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('400.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testAnUnknownErrorRaisesAGenericException()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whois('409.com');
    }

    public function testGetAccountInformation()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $account    = $robowhois->account();

        $this->assertInstanceOf('Robowhois\Account', $account);
        $this->assertEquals('4ef12dbfca71cce5fd000001', $account['id']);
        $this->assertEquals('email@example.com', $account['email']);
        $this->assertEquals('0123456789', $account['api_token']);
        $this->assertEquals(480, $account['credits_remaining']);
        $this->assertEquals(480, $account->getCreditsRemaining());
    }
    
    /**
     * @expectedException Robowhois\Exception
     */
    public function testDomainAvailabilityWithAMalformedResponse()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $availability = $robowhois->domainAvailability('availablebutmalformed.com'); 
    }
    
    public function testADomainIsAvailable()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $availability = $robowhois->domainAvailability('available.com'); 
        
        $this->assertTrue($availability['available']);
        $this->assertFalse($availability['registered']);
        $this->assertEquals('2012-01-01', $availability['daystamp']);
    }
    
    public function testAvailabilityConvenientMethods()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        
        $this->assertTrue($robowhois->isAvailable('available.com'));
        $this->assertFalse($robowhois->isRegistered('available.com'));
    }
    
    public function testWhoisProperties()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $domain     = $robowhois->whoisProperties('propertydomain.com');

        $this->assertEquals('2011-08-23', $domain['daystamp']);
    }
}

