<?php

namespace App\Entity\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint as AppAssert;

#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\Category', property: 'name')]
class CreateCategoryDto
{
    #[Assert\Length(min:3, max: 255)]
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}