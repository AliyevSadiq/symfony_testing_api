<?php


namespace App\CQRS\CommandBus\Handlers\Product;


use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Product\SaveProductCommand;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class SaveProductCommandHandler implements CommandHandler
{

    public function __construct(private ProductRepository $productRepository,private CategoryRepository $categoryRepository)
    {
    }

    public function __invoke(SaveProductCommand $command)
    {
        $category=$this->categoryRepository->find($command->category_id);


        $entity=$command->product??new Product();

        $entity->setTitle($command->title)
            ->setPrice($command->price)
            ->setIsShow($command->is_show)
            ->setDescription($command->description)
            ->setCategory($category);

        $this->productRepository->save($entity,true);
        $command->product=$entity;
    }
}