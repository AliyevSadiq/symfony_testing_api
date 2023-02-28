<?php


namespace App\CQRS\CommandBus\Handlers\Category;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Category\DeleteCategoryCommand;
use App\CQRS\CommandBus\Commands\Category\SaveCategoryCommand;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class DeleteCategoryCommandHandler implements CommandHandler
{
    public function __construct(protected CategoryRepository $repository)
    {
    }

    public function __invoke(DeleteCategoryCommand $command)
    {
        $this->repository->remove($command->category);
    }
}