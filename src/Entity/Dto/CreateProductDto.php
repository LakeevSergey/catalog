<?php

namespace App\Entity\Dto;

class CreateProductDto
{
    private string $name;

    private int $categoryId;

    private string $sku;

    private float $price;

    private int $quantity;

    public function __construct(string $name, int $categoryId, string $sku, float $price, int $quantity)
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->sku = $sku;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}