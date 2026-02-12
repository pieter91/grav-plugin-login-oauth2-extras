<?php

namespace Pietervanderweel\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class ScoutingUser implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->response['sub'];
    }

    /**
     * @return mixed
     */
    public function getSOLId()
    {
        return $this->response['member_id'] ?? "";
    }

    /**
     * Get preferred display name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->response['name'];
    }

    /**
     * Get preferred first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->response['given_name'];
    }

    /**
     * Get preferred infix.
     *
     * @return string|null
     */
    public function getInfix()
    {
        if (array_key_exists('infix', $this->response)) {
            return $this->response['infix'];
        }
        return null;
    }


    /**
     * Get preferred last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->response['family_name'];
    }

    /**
     * Get email address.
     *
     * @return string|null
     */
    public function getEmail()
    {
        if (array_key_exists('email', $this->response)) {
            return $this->response['email'];
        }
        return null;
    }

    /**
     * Get email verified.
     *
     * @return bool
     */
    public function getEmailVerified()
    {
        if (array_key_exists('email_verified', $this->response)) {
            return $this->response['email_verified'];
        }
        return false;
    }
    
    /**
     * Get preferred username.
     *
     * @return string|null
     */
    public function getFullName()
    {
        if (array_key_exists('name', $this->response)) {
            return $this->response['name'];
        }
        return null;
    }

    /**
     * Get user data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
