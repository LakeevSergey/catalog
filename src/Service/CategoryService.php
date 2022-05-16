<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Dto\CreateCategoryDto;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryService
{
    private CategoryRepository $repository;
    private ValidatorInterface $validator;

    public function __construct(CategoryRepository $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(CreateCategoryDto $createCategoryDto): Category
    {
        $errors = $this->validator->validate($createCategoryDto);

        if ($errors->count()) {
            throw new ValidationFailedException($createCategoryDto, $errors);
        }
        $category = new Category($createCategoryDto->name);
        $this->repository->add($category, true);

        return $category;
    }

    public function get(int $id): Category
    {
        return $this->repository->find($id);
    }
}