<?php

namespace App\Service;

use App\Entity\Dto\CreateProductDto;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CreateProductDto $createProductDto): Product
    {
        $category = $this->categoryRepository->find($createProductDto->getCategoryId());
        $product = new Product(
            $createProductDto->getName(),
            $category,
            $createProductDto->getSku(),
            $createProductDto->getPrice(),
            $createProductDto->getQuantity()
        );

        $this->productRepository->add($product, true);

        return $product;
    }
}