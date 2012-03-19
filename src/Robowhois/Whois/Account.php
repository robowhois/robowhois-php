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
 * Class Index
 *
 * @package     Robowhois
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 * @author      David Funaro <ing.davidino@gmail.com>
 */

namespace Robowhois\Whois;

class Account
{
    protected $id;
    protected $email;
    protected $api_token;
    protected $credits_remaining;

    
    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $values = json_decode($content, true);
        $value = array_key_exists('account', $values) ? $values['account'] : null;

        if (!count($value))  
            throw new Exception();

        $this->id                = array_key_exists('id', $value)                ? $value['id']        : null;
        $this->email             = array_key_exists('email', $value)             ? $value['email']     : null;
        $this->api_token         = array_key_exists('api_token', $value)         ? $value['api_token'] : null;
        $this->credits_remaining = array_key_exists('credits_remaining', $value) ? $value['credits_remaining'] : null;
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        return $this->api_token;
    }

    /**
     * @return integer
     */
    public function getCreditsRemaining()
    {
        return $this->credits_remaining;
    }
}