<?php


namespace App\CQRS\CommandBus\Handlers\User;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\User\UpdateRoleCommand;
use App\Entity\Permission;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateRoleCommandHandler implements CommandHandler
{
    public function __construct(private PermissionRepository $permissionRepository,
                                private EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(UpdateRoleCommand $command)
    {
        $command->user->setRoles([$command->role]);
        if (!empty($command->permissions) && $command->role=='ROLE_MODERATOR') {
            $this->permissionRepository->removeAll(['user_id'=>$command->user->getId()]);
            foreach (array_unique($command->permissions) as $permission) {
                $permissionEntity = new Permission();
                $permissionEntity
                    ->setPermissionName($permission);
                $command->user->addPermission($permissionEntity);
                $this->entityManager->persist($permissionEntity);
            }
            $this->entityManager->flush();
        }
        $this->entityManager->persist($command->user);
        $this->entityManager->flush();
    }
}