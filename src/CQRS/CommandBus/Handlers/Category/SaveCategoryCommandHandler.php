<?php


namespace App\CQRS\CommandBus\Handlers\Category;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Category\SaveCategoryCommand;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class SaveCategoryCommandHandler implements CommandHandler
{
    public function __construct(protected CategoryRepository $repository)
    {
    }


    public function __invoke(SaveCategoryCommand $command)
    {
        $entity =$command->category??new Category();

        $entity
            ->setTitle($command->title)
            ->setIsShow($command->is_show);

        $this->repository->save($entity,true);
        $command->category=$entity;
    }
}