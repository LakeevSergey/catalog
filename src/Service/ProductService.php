<?php

namespace App\Service;

use App\Entity\Dto\CreateProductDto;
use App\Entity\Dto\EditProductDto;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    private ValidatorInterface $validator;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, ValidatorInterface $validator)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
    }

    /**
     * @param CreateProductDto $createProductDto
     * @return Product
     */
    public function create(CreateProductDto $createProductDto): Product
    {
        $errors = $this->validator->validate($createProductDto);

        if ($errors->count()) {
            throw new ValidationFailedException($createProductDto, $errors);
        }
        $category = $this->categoryRepository->find($createProductDto->categoryId);
        $product = new Product(
            $createProductDto->name,
            $category,
            $createProductDto->sku,
            $createProductDto->price,
            $createProductDto->quantity
        );

        $this->productRepository->add($product, true);

        return $product;
    }

    /**
     * @param EditProductDto $editProductDto
     * @return Product
     * @throws EntityNotFoundException
     */
    public function edit(EditProductDto $editProductDto): Product
    {
        $errors = $this->validator->validate($editProductDto);

        if ($errors->count()) {
            throw new ValidationFailedException($editProductDto, $errors);
        }
        $category = $this->categoryRepository->find($editProductDto->categoryId);
        $product = $this->get($editProductDto->id);

        $product->edit(
            $editProductDto->name,
            $category,
            $editProductDto->sku,
            $editProductDto->price,
            $editProductDto->quantity
        );

        $this->productRepository->add($product, true);

        return $product;
    }

    /**
     * @param int $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function get(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new EntityNotFoundException('Product not found');
        }
        return $product;
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param int $id Product id
     * @return void
     * @throws EntityNotFoundException
     */
    public function delete(int $id): void
    {
        $product = $this->get($id);
        $this->productRepository->remove($product, true);
    }

    /**
     * @return float
     */
    public function getTotalValue(): float
    {
        return $this->productRepository->getTotalValue();
    }
}