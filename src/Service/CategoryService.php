<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Dto\CreateCategoryDto;
use App\Repository\CategoryRepository;

class CategoryService
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateCategoryDto $createCategoryDto): Category
    {
        $category = new Category($createCategoryDto->getName());
        $this->repository->add($category, true);

        return $category;
    }

    public function get(int $id): Category
    {
        return $this->repository->find($id);
    }
}