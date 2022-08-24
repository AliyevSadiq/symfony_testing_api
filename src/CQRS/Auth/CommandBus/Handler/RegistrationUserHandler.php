<?php

namespace App\CQRS\Auth\CommandBus\Handler;

use App\CQRS\Auth\CommandBus\Command\RegistrationUserCommand;
use App\CQRS\Common\Command\CommandHandler;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationUserHandler implements CommandHandler
{

    private UserRepository $repository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $repository,UserPasswordHasherInterface $passwordHasher)
    {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke(RegistrationUserCommand $command)
    {
        $user=new User();

        $user->setEmail($command->email);


        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $command->password
        );


        $user->setPassword($hashedPassword);

        $this->repository->add($user, true);

        $command->user = $user;
    }
}