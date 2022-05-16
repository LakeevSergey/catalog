<?php

namespace App\Service;

use App\Entity\Dto\LoginDto;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private JWTTokenManagerInterface $JWTTokenManager;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTTokenManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->JWTTokenManager = $JWTTokenManager;
    }

    public function login(LoginDto $userLoginDto): string
    {
        $user = $this->userRepository->findOneByLogin($userLoginDto->login);

        if (!$user) {
            throw new AccessDeniedHttpException("Incorrect login or password");
        }

        $isPasswordValid = $this->passwordHasher->isPasswordValid($user, $userLoginDto->password);

        if (!$isPasswordValid) {
            throw new AccessDeniedHttpException("Incorrect login or password");
        }
        return $this->JWTTokenManager->create($user);
    }
}