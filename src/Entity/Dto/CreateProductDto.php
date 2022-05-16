<?php

namespace App\Entity\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint as AppAssert;

#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\Product', property: 'name')]
#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\Product', property: 'sku')]
class CreateProductDto
{
    #[Assert\Length(min:3, max: 255)]
    public string $name;

    public int $categoryId;

    #[Assert\Length(min:3, max: 255)]
    public string $sku;

    public float $price;

    public int $quantity;

    public function __construct(string $name, int $categoryId, string $sku, float $price, int $quantity)
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->sku = $sku;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}