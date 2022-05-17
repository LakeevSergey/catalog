<?php

namespace App\Entity\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint as AppAssert;

#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\Product', property: 'name', primaryKey: 'id')]
#[AppAssert\UniqueEntityProperty(entity: 'App\Entity\Product', property: 'sku', primaryKey: 'id')]
class EditProductDto
{
    public int $id;

    #[Assert\Length(min:3, max: 255)]
    public string $name;

    public int $categoryId;

    #[Assert\Length(min:3, max: 255)]
    public string $sku;

    #[Assert\PositiveOrZero]
    public float $price;

    #[Assert\PositiveOrZero]
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