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
 * Class Client
 *
 * @package     RoboWhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Stub\Http;

use RoboWhois\Contract\Http\Client as ClientInterface;
use \Symfony\Component\HttpFoundation\Response;

class Client implements ClientInterface
{
    public function authenticate($apiKey)
    {
        
    }
    
    /**
     * @param string $uri
     *  
     * @return \Symfony\Component\HttpFoundation\Response;
     */
    public function get($uri)
    {
        $path = self::getPath($uri);

        $headers    = $this->getHeaders($uri);
        $statusCode = file_get_contents($path. '/' . 'statusCode');
        $content    = file_get_contents($path. '/' . 'content');

        return new Response($content,$statusCode,$headers);
      
    }
    
    /**
     * @return string
     */
    public static function getContent($uri)
    {
        $path       = self::getPath($uri);
        $content    = file_get_contents($path. '/' . 'content');
        
        return $content;
    }
    
    private function getHeaders($uri)
    {
        $headers = array();
        
        $path = self::getPath($uri);

        $headersFile = $path. '/' . 'headers';
        if (file_exists($headersFile)){
            $items    = file_get_contents($path. '/' . 'headers');
            
            if(strlen($items)>0) {

                $lines = explode("\n", $items);
                    
                foreach ($lines as $header) {
                    $single = explode('=>', $header);
                    $headers[$single[0]] = $single[1];
                }
            }
        }

        return $headers;   
    }
  
    private static function getPath($uri)
    {
        if(strpos($uri, 'account'))
            return __DIR__ . '/../../bin/' . 'account';
        
        return __DIR__ . '/../../bin/'.str_replace("http://api.robowhois.com/whois/", null, $uri);
                
    }  
}

