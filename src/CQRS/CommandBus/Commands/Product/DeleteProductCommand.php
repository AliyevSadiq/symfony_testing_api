<?php


namespace App\CQRS\CommandBus\Commands\Product;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\Product;

class DeleteProductCommand extends AbstractCommand
{
  public Product $product;
}