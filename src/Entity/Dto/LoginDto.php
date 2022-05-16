<?php

namespace App\Entity\Dto;

class LoginDto
{
    public string $login;

    public string $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }
}