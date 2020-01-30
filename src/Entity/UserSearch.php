<?php

namespace App\Entity;

class UserSearch {
    
    private $email;

    

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}