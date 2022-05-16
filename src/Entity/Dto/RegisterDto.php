<?php

namespace App\Entity\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint as AppAssert;

#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\User', property: 'login')]
#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\User', property: 'name')]
class RegisterDto
{
    #[Assert\Length(min:3, max: 255)]
    public string $name;

    #[Assert\Length(min:3, max: 255)]
    public string $login;

    #[Assert\Length(min: 8, max: 20)]
    public string $password;

    public function __construct($name, $login, $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }
}