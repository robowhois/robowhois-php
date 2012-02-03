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
 * Class Client
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Stub\Http;

use Robowhois\Contract\Http\Client as ClientInterface;
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
        $headers = array();
        $file    = file_get_contents(__DIR__ . '/../../bin/'.str_replace("http://api.robowhois.com/whois/", null, $uri));
        $parts   = explode('***', $file);
        
        $statusCode = $parts[0];
        $content    = $parts[1];
        
        if (count($parts) == 3) {
            $content = $parts[2];
            
            $hs = explode('^', $parts[1]);
            
            foreach ($hs as $header) {
                $single = explode('=>', $header);
                $headers[$single[0]] = $single[1];
            }
        }
      
        return new Response($content,$statusCode,$headers);
      
    }
    
    /**
     * @return string
     */
    public static function  stripMetaInfo($path)
    {
        $file    = file_get_contents($path);
        $parts   = explode('***', $file);
        
        $statusCode = $parts[0];    
        $content    = $parts[1];
        
        if (count($parts) == 3) {
            $content = $parts[2];
            
            $hs = explode('^', $parts[1]);
            
            foreach ($hs as $header) {
                $single = explode('=>', $header);      
                $headers[$single[0]] = $single[1];
            }
        }
        
        return $content;
    }
  
  
}

