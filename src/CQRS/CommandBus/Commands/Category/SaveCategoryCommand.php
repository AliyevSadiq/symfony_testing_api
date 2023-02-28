<?php


namespace App\CQRS\CommandBus\Commands\Category;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\Category;

class SaveCategoryCommand extends AbstractCommand
{
    public string $title;
    public ?bool $is_show=false;
    public ?Category $category=null;
}