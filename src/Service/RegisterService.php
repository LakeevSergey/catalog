<?php

namespace App\Service;

use App\Entity\Dto\RegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $repository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
    }

    public function register(RegisterDto $registerDto)
    {
        $user = new User($registerDto->getName(), $registerDto->getLogin());

        $passwordHash = $this->passwordHasher->hashPassword($user, $registerDto->getPassword());
        $user->setPassword($passwordHash);
        $this->repository->add($user);

        return $user;
    }
}