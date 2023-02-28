<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    protected function loadData(ObjectManager $manager)
    {
       $categories=$this->repository->findAll();

       $this->createMany(Product::class,100,function (Product $product,$count) use($categories){
           $product->setTitle($this->faker->unique(true)->text(10))
               ->setIsShow($this->faker->boolean)
               ->setPrice(rand(100,1000))
               ->setDescription($this->faker->text(200))
               ->setCategory($this->faker->randomElement($categories));
       });
       $manager->flush();
    }


    public function getDependencies()
    {
        return [
          CategoryFixtures::class
        ];
    }
}
