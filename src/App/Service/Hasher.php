<?php

namespace App\Service;

class Hasher
{
    /** @var string */
    private $salt;
    
    /**
     * @param string $salt
     */
    public function __construct(string $salt)
    {
        $this->salt = $salt;
    }
    
    /**
     * @param string $password
     *
     * @return string
     */
    public function md5(string $password): string
    {
        return md5($password . ';' . $this->salt);
    }
}
