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
    public function testARegisteredDomain()
    {
        $domain     = 'www.index.com';
        $filePath   = __DIR__.'/bin/'. $domain;
        
        $robowhois  = new Robowhois("aaa", new Client);
        $index      = $robowhois->whoisIndex($domain);
        
        ob_start();
        echo $index;
        $content = ob_get_contents();
        ob_end_clean();
        
        $fileContents = file_get_contents($filePath);
        $fileContents = Client::getContent($domain);
        
        $this->assertEquals($content, $fileContents);
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Request\Unauthorized 
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsWithAnInvalidApiKey()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $index      = $robowhois->whoisIndex('wrongapikey.com');      
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Response\NotFound
     */
    public function testAnExceptionIsRaisedWhenExecutingRequestsToNonExistingAPIEndpoints()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('notfound.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Response\BadGateway
     */
    public function testAnExceptionIsRaisedWhenABadgatewayErrorOccurs()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('502.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Response\ServerError
     */
    public function testAnExceptionIsRaisedWhenAnIntervalServerErrorOccurs()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('500.com'); 
    }

    /**
     * @expectedException Robowhois\Exception\Http\Response\VoidResponse
     */
    public function testAnExceptionIsRaisedWhenVoidResponse()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('void.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception\Http\Request\Bad
     */
    public function testAGenericErrorRaisesABadRequestException()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('400.com'); 
    }
    
    /**
     * @expectedException Robowhois\Exception\Http
     */
    public function testAnUnknownErrorRaisesAGenericException()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $robowhois->whoisIndex('409.com');
    }

    public function testGetAccountInformation()
    {
        $robowhois  = new Robowhois("aaa", new Client);
        $account    = $robowhois->whoisAccount();

        $this->assertInstanceOf('Robowhois\Whois\Account', $account);
        $this->assertEquals('4ef12dbfca71cce5fd000001', $account->getId());
        $this->assertEquals('email@example.com', $account->getEmail());
        $this->assertEquals('0123456789', $account->getApiToken());
        $this->assertEquals(480, $account->getCreditsRemaining());
    }
}

