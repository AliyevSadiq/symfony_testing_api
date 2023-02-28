<?php

namespace App\Controller;

use App\CQRS\CommandBus\CommandBus;
use App\CQRS\CommandBus\Commands\Auth\ChangePasswordCommand;
use App\CQRS\CommandBus\Commands\Auth\ResetPasswordCommand;
use App\Requests\ChangePasswordRequest;
use App\Requests\ResetPasswordRequest;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth')]
#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'test@mail.com', property: 'email')
        ])
    )]
    #[Security(name: null)]
    #[Route('/',name: 'request_password',methods: ['POST'])]
    public function requestPassword(ResetPasswordRequest $request)
    {
      try{
          $command=new ResetPasswordCommand($request->getRequest());
          $this->commandBus->dispatch($command);
          return $this->json([
              'message'=>'email sent for changing email'
          ]);
      }catch (\Exception $exception){
          return $this->json([
              'message'=>$exception->getMessage()
          ]);
      }
   }
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: '1234', property: 'password')
        ])
    )]
    #[Security(name: null)]
    #[Route('/reset/{token}', name: 'app_reset_password',methods: ['POST'])]
    public function reset(ChangePasswordRequest $request, string $token = null)
    {
        try{
            $extra_field=[];

            if ($token){
                $extra_field['token']=$token;
            }

            $command=new ChangePasswordCommand($request->getRequest($extra_field));
            $this->commandBus->dispatch($command);
            return $this->json([
                'message'=>'user password reset'
            ]);
        }catch (\Exception $exception){
            return $this->json([
                'message'=>$exception->getMessage()
            ]);
        }
   }
}
