<?php

namespace App\Service;

use App\Entity\Dto\CreateProductDto;
use App\Entity\Dto\EditProductDto;
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

    public function edit(EditProductDto $editProductDto): Product
    {
        $category = $this->categoryRepository->find($editProductDto->getCategoryId());
        $product = $this->productRepository->find($editProductDto->getId());

        $product->edit(
            $editProductDto->getName(),
            $category,
            $editProductDto->getSku(),
            $editProductDto->getPrice(),
            $editProductDto->getQuantity()
        );

        $this->productRepository->add($product, true);

        return $product;
    }

    public function get(int $id): Product
    {
        return $this->productRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }

    public function delete(int $id): void
    {
        $product = $this->get($id);
        $this->productRepository->remove($product, true);
    }
}