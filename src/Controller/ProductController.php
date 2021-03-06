<?php

namespace App\Controller;

use App\Entity\Dto\CreateProductDto;
use App\Entity\Dto\EditProductDto;
use App\Entity\User;
use App\Service\ProductService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/product')]
class ProductController extends AbstractController
{
    private SerializerInterface $serializer;
    private ProductService $productService;

    public function __construct(SerializerInterface $serializer, ProductService $productService)
    {
        $this->serializer = $serializer;
        $this->productService = $productService;
    }

    #[Route('/', name: 'product_create', methods: 'POST')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        $createProductDto = $this->serializer->deserialize($request->getContent(), CreateProductDto::class, JsonEncoder::FORMAT);
        $product = $this->productService->create($createProductDto);
        $json = $this->serializer->serialize(['status' => 201, 'data' => $product], 'json');

        return new JsonResponse($json, 201, [], true);
    }

    #[Route('/{id}/', name: 'product_edit', methods: 'POST')]
    public function edit(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        $editProductDto = $this->serializer->deserialize($request->getContent(), EditProductDto::class, JsonEncoder::FORMAT);
        $editProductDto->id = $id;

        try {
            $product = $this->productService->edit($editProductDto);
        } catch (EntityNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        $json = $this->serializer->serialize(['status' => 201, 'data' => $product], 'json');

        return new JsonResponse($json, 201, [], true);
    }

    #[Route('/total_value/', name: 'product_total_value', methods: 'GET')]
    public function getTotalValue(): Response
    {
        $totalValue = $this->productService->getTotalValue();
        $json = $this->serializer->serialize(['status' => 200, 'data' => $totalValue], 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/{id}/', name: 'product_get', methods: 'GET')]
    public function get(int $id): Response
    {
        try {
            $product = $this->productService->get($id);
        } catch (EntityNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        $json = $this->serializer->serialize(['status' => 200, 'data' => $product], 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/', name: 'product_get_all', methods: 'GET')]
    public function getAll(): Response
    {
        $products = $this->productService->getAll();
        $json = $this->serializer->serialize(['status' => 200, 'data' => $products], 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/{id}/', name: 'product_delete', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        try {
            $this->productService->delete($id);
        } catch (EntityNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        $json = $this->serializer->serialize(['status' => 202, 'data' => []], 'json');

        return new JsonResponse($json, 202, [], true);
    }
}