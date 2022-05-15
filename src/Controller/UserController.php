<?php

namespace App\Controller;

use App\Entity\Dto\RegisterDto;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    private SerializerInterface $serializer;
    private RegisterService $registerService;

    public function __construct(SerializerInterface $serializer, RegisterService $registerService)
    {
        $this->serializer = $serializer;
        $this->registerService = $registerService;
    }

    #[Route('/register/', name: 'user_register', methods: 'POST')]
    public function register(Request $request): Response
    {
        $registerDto = $this->serializer->deserialize($request->getContent(), RegisterDto::class, JsonEncoder::FORMAT);
        $user = $this->registerService->register($registerDto);
        $json = $this->serializer->serialize(['status' => 201, 'data' => $user], 'json');

        return new JsonResponse($json, 201, [], true);
    }
}