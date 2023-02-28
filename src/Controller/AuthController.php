<?php

namespace App\Controller;

use App\CQRS\CommandBus\CommandBus;
use App\CQRS\CommandBus\Commands\Auth\EmailVerifiedCommand;
use App\CQRS\CommandBus\Commands\Auth\RegistrationCommand;
use App\Repository\RefreshTokenRepository;
use App\Requests\RegistrationRequest;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth')]
class AuthController extends AbstractController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'test@mail.com', property: 'email'),
            new OA\Property(type: 'string', example: 'new_username', property: 'username'),
            new OA\Property(type: 'string', example: '1234', property: 'password'),
        ])
    )]
    #[Security(name: null)]
    #[Route('/auth/registration', name: 'registration', methods: ['POST'])]
    public function registration(RegistrationRequest $request): Response
    {
        $command = new RegistrationCommand($request->getRequest());
        $this->commandBus->dispatch($command);
        return $this->json(['message' => 'Registered Successfully']);
    }


    #[Security(name: null)]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'test@mail.com', property: 'email'),
            new OA\Property(type: 'string', example: '1234', property: 'password'),
        ])
    )]
    #[Route('/auth/login', name: 'login', methods: ['POST'])]
    public function login()
    {

    }

    #[Route('/logout', name: 'logout', methods: ['POST'])]
    public function logout(RefreshTokenRepository $repository)
    {
        $repository->removeByEmail($this->getUser()->getUserIdentifier());
        return $this->json([
            'message' => 'logout'
        ]);
    }
    #[Security(name: null)]
    #[Route('/auth/email-verification',name: 'email_verification', methods: ['GET'])]
    public function emailVerified(Request $request)
    {
        try{
            $command=new EmailVerifiedCommand([
                'user_id'=>$request->get('id'),
                'url'=>$request->getUri(),
            ]);
            $this->commandBus->dispatch($command);
            return $this->json([
                'message'=>'user is verified'
            ]);
        }catch (\Exception $exception){
            return $this->json([
                'message'=>$exception->getMessage()
            ]);
        }
    }


}
