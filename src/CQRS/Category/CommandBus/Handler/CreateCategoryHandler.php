<?php

namespace App\CQRS\Category\CommandBus\Handler;

use App\CQRS\Category\CommandBus\Command\CreateCategoryCommand;
use App\CQRS\Common\Command\CommandHandler;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class CreateCategoryHandler implements CommandHandler
{

    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCategoryCommand $categoryCommand)
    {
        $category=new Category();

        $category->setTitle($categoryCommand->title)
            ->setIsActive($categoryCommand->is_active??false);

        $this->repository->add($category,true);


        $categoryCommand->category=$category;
    }
}