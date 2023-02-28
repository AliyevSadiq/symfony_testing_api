<?php

namespace App\Controller\Admin;

use App\CQRS\CommandBus\CommandBus;
use App\CQRS\CommandBus\Commands\User\DeleteUserCommand;
use App\CQRS\CommandBus\Commands\User\UpdateRoleCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Requests\UpdateRoleRequest;
use App\Utils\Collection\Resource\UserResourceCollection;
use App\Utils\Collection\UserCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Admin User Crud')]
#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    public function __construct(private CommandBus $commandBus)
    {
    }


    #[Route('/', name: 'index',methods: ['GET'])]
    public function index(UserRepository $repository): JsonResponse
    {
        return $this->json([
            'users' =>UserCollection::collection($repository->findAll()),
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET'], priority: 1)]
    public function edit(User $user): JsonResponse
    {
        return $this->json([
            'user' => (new UserResourceCollection($user))->get()
        ]);
    }
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'ROLE_MODERATOR', property: 'role'),
            new OA\Property(type: 'array', items: new OA\Items(example: 'permission1'), property: 'permissions'),
        ])
    )]
    #[Route('/{id}/update-role', name: 'update_role', methods: ['PUT'], priority: 2)]
    public function updateRole(User $user,UpdateRoleRequest $request)
    {
        try{
            $extra_field=[];
            if ($user){
                $extra_field['user']=$user;
            }
            $command=new UpdateRoleCommand($request->getRequest($extra_field));
            $this->commandBus->dispatch($command);
            return $this->json([
                'user' => (new UserResourceCollection($command->user))->get()
            ]);
        }
        catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }

    #[Route('/{id}/delete', name:'delete',methods: ['DELETE'])]
    public function delete(User $user)
    {
        $command=new DeleteUserCommand([
            'user'=>$user
        ]);
        $this->commandBus->dispatch($command);
        return $this->json([
            'User deleted'
        ]);
    }
}
