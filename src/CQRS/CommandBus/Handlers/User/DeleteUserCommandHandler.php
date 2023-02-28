<?php


namespace App\CQRS\CommandBus\Handlers\User;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Category\DeleteCategoryCommand;
use App\CQRS\CommandBus\Commands\Category\SaveCategoryCommand;
use App\CQRS\CommandBus\Commands\User\DeleteUserCommand;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

class DeleteUserCommandHandler implements CommandHandler
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function __invoke(DeleteUserCommand $command)
    {
        $this->repository->remove($command->user);
    }
}