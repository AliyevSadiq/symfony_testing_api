<?php

namespace App\CQRS\Category\CommandBus\Command;

use App\CQRS\Common\Command\Command;
use App\Entity\Category;


class DeleteCategoryCommand implements Command
{
    public Category $category;


    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}