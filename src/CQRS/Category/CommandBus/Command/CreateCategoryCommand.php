<?php

namespace App\CQRS\Category\CommandBus\Command;

use App\CQRS\Common\Command\Command;
use App\Entity\Category;


class CreateCategoryCommand implements Command
{
    public string $title;
    public ?bool $is_active;

    public Category $category;


    public function __construct(string $title,?bool $is_active=false)
    {
        $this->title = $title;

        $this->is_active = $is_active;
    }
}