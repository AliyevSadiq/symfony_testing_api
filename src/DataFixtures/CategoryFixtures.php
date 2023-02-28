<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixtures
{

    protected function loadData(ObjectManager $manager)
    {
       $this->createMany(Category::class,10,function (Category $category,$count)use($manager){
           $title=$this->faker->unique(true)->text(20);
            $category->setTitle($title)
                ->setIsShow($this->faker->boolean(70));
       });

       $manager->flush();
    }
}
