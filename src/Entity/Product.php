<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\Column(type: 'string', length: 255)]
    private string $sku;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function __construct(string $name, Category $category, string $sku, float $price, int $quantity)
    {
        $this->name = $name;
        $this->category = $category;
        $this->sku = $sku;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}
