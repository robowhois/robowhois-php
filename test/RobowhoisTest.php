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

class RobowhoisTest extends PHPUnit_Framework_TestCase
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
        $fileContents = Client::stripMetaInfo($filePath);
        
        $this->assertEquals($content,$fileContents);
        $this->assertInstanceOf('Robowhois\Whois\Index', $index);
    }
}

