<?php

namespace App\Controller;

use App\Entity\Dto\CreateCategoryDto;
use App\Entity\User;
use App\Service\CategoryService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/category')]
class CategoryController extends AbstractController
{
    private SerializerInterface $serializer;
    private CategoryService $categoryService;

    public function __construct(SerializerInterface $serializer, CategoryService $categoryService)
    {
        $this->serializer = $serializer;
        $this->categoryService = $categoryService;
    }

    #[Route('/', name: 'category_create', methods: 'POST')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        $createCategoryDto = $this->serializer->deserialize($request->getContent(), CreateCategoryDto::class, JsonEncoder::FORMAT);
        $category = $this->categoryService->create($createCategoryDto);
        $json = $this->serializer->serialize(['status' => 201, 'data' => $category], 'json');

        return new JsonResponse($json, 201, [], true);
    }

    #[Route('/{id}/', name: 'category_get', methods: 'GET')]
    public function get(int $id): Response
    {
        try {
            $category = $this->categoryService->get($id);
        } catch (EntityNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        $json = $this->serializer->serialize(['status' => 200, 'data' => $category], 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/', name: 'category_get_all', methods: 'GET')]
    public function getAll(): Response
    {
        $categories = $this->categoryService->getAll();
        $json = $this->serializer->serialize(['status' => 200, 'data' => $categories], 'json');

        return new JsonResponse($json, 200, [], true);
    }
}