<?php


namespace App\Utils\Collection\Resource;


use App\Entity\Category;
use App\Entity\Product;
use App\Utils\Contract\AbstractResourceCollection;

class ProductResourceCollection extends AbstractResourceCollection
{

    /**
     * @param Product $item
     * @return array
     */
    protected function field($item)
    {
        return [
            'id'=>$item->getId(),
            'title'=>$item->getTitle(),
            'slug'=>$item->getSlug(),
            'description'=>$item->getDescription(),
            'category'=>$item->getCategory()->getTitle(),
        ];
    }
}