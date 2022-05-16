<?php

namespace App\Service;

use App\Entity\Dto\RegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterService
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $passwordHasher;
    private ValidatorInterface $validator;

    public function __construct(UserRepository $repository, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator)
    {
        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function register(RegisterDto $registerDto)
    {
        $errors = $this->validator->validate($registerDto);

        if ($errors->count()) {
            throw new ValidationFailedException($registerDto, $errors);
        }
        $user = new User($registerDto->name, $registerDto->login);

        $passwordHash = $this->passwordHasher->hashPassword($user, $registerDto->password);
        $user->setPassword($passwordHash);
        $this->repository->add($user, true);

        return $user;
    }
}