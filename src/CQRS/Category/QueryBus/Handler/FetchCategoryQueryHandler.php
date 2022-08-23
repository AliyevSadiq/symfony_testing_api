<?php

namespace App\CQRS\Category\QueryBus\Handler;

use App\CQRS\Category\QueryBus\Query\FetchCategoriesQuery;
use App\CQRS\Common\Query\QueryHandler;
use App\DTO\Response\Transformer\CategoryResponseDtoTransformer;
use App\Repository\CategoryRepository;

class FetchCategoryQueryHandler implements QueryHandler
{
    private  CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchCategoriesQuery $categoriesQuery)
    {
        return (new CategoryResponseDtoTransformer())->transformerFromObjects($this->repository->findAll());
    }
}