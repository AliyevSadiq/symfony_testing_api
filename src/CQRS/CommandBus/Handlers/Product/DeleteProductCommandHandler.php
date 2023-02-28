<?php


namespace App\CQRS\CommandBus\Handlers\Product;


use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Product\DeleteProductCommand;
use App\CQRS\CommandBus\Commands\Product\SaveProductCommand;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class DeleteProductCommandHandler implements CommandHandler
{

    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function __invoke(DeleteProductCommand $command)
    {
        $this->productRepository->remove($command->product);
    }
}