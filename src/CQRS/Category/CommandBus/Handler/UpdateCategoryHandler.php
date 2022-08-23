<?php

namespace App\CQRS\Category\CommandBus\Handler;

use App\CQRS\Category\CommandBus\Command\UpdateCategoryCommand;
use App\CQRS\Common\Command\CommandHandler;
use App\Repository\CategoryRepository;

class UpdateCategoryHandler implements CommandHandler
{

    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateCategoryCommand $categoryCommand)
    {
        $category=$categoryCommand->category;

        $category->setTitle($categoryCommand->title)
            ->setIsActive($categoryCommand->is_active??false);

        $this->repository->add($category,true);
    }
}