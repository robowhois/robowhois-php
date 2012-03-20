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

namespace Robowhois;

class Account
{
    protected $id;
    protected $email;
    protected $api_token;
    protected $credits_remaining;

    
    /**
     * @param string  $id
     * @param string  $email
     * @param string  $api_tokem
     * @param integer $credits_remaining
     */
    public function __construct($id, $email, $api_token, $credits_remaining)
    {
        $this->id                = $id;
        $this->email             = $email;
        $this->api_token         = $api_token;
        $this->credits_remaining = $credits_remaining;
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