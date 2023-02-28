<?php


namespace App\CQRS\CommandBus\Commands\Product;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\Product;

class SaveProductCommand extends AbstractCommand
{
  public string $title;
  public string $description;
  public ?bool $is_show=false;
  public float $price;
  public int $category_id;
  public Product $product;
}