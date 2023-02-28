<?php


namespace App\CQRS\CommandBus\Handlers\Auth;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Auth\RegistrationCommand;
use App\Entity\User;
use App\Message\SendEmailVerificationMessage;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationCommandHandler implements CommandHandler
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $repository,
        private MessageBusInterface  $messageBus
    )
    {
    }


    public function __invoke(RegistrationCommand $command)
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $command->password
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($command->email);
        $user->setUsername($command->username);
        $this->repository->save($user, true);
        $event = new SendEmailVerificationMessage($user);
        $this->messageBus->dispatch($event);
    }
}