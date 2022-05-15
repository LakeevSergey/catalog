<?php

namespace App\Service;

use App\Entity\Dto\RegisterDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function register(RegisterDto $registerDto)
    {
        $user = new User($registerDto->getName(), $registerDto->getLogin());

        $passwordHash = $this->passwordHasher->hashPassword($user, $registerDto->getPassword());
        $user->setPassword($passwordHash);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}