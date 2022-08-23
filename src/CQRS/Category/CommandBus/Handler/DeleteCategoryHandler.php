<?php

namespace App\CQRS\Category\CommandBus\Handler;

use App\CQRS\Category\CommandBus\Command\DeleteCategoryCommand;
use App\CQRS\Common\Command\CommandHandler;
use App\Repository\CategoryRepository;

class DeleteCategoryHandler implements CommandHandler
{

    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteCategoryCommand $categoryCommand)
    {
        $this->repository->remove($categoryCommand->category,true);
    }
}