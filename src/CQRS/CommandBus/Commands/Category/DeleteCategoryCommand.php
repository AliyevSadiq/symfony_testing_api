<?php


namespace App\CQRS\CommandBus\Commands\Category;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\Category;

class DeleteCategoryCommand extends AbstractCommand
{
    public Category $category;
}