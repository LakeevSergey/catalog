<?php

namespace App\Controller;

use App\Entity\Dto\CreateProductDto;
use App\Entity\Dto\EditProductDto;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/create/', name: 'product_create', methods: 'POST')]
    public function create(Request $request): Response
    {
        $createProductDto = $this->serializer->deserialize($request->getContent(), CreateProductDto::class, JsonEncoder::FORMAT);
        $product = $this->productService->create($createProductDto);
        $json = $this->serializer->serialize(['status' => 201, 'data' => $product], 'json');

        return new JsonResponse($json, 201, [], true);
    }

    #[Route('/{id}/edit/', name: 'product_create', methods: 'POST')]
    public function edit(Request $request, int $id): Response
    {
        $editProductDto = $this->serializer->deserialize($request->getContent(), EditProductDto::class, JsonEncoder::FORMAT);
        $editProductDto->setId($id);
        $product = $this->productService->edit($editProductDto);
        $json = $this->serializer->serialize(['status' => 201, 'data' => $product], 'json');

        return new JsonResponse($json, 201, [], true);
    }
}