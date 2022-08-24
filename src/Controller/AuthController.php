<?php

namespace App\Controller;

use App\CQRS\Auth\CommandBus\Command\RegistrationUserCommand;
use App\CQRS\Common\Command\CommandBus;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(RegisterRequest $request)
    {
       $command=new RegistrationUserCommand($request->email,$request->password);
       $this->commandBus->dispatch($command);
       return $this->json([
           'user'=>$command->user
       ]);
    }
}
