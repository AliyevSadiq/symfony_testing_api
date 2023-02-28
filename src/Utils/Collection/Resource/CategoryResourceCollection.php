<?php


namespace App\Utils\Collection\Resource;


use App\Entity\Category;
use App\Utils\Contract\AbstractResourceCollection;

class CategoryResourceCollection extends AbstractResourceCollection
{

    /**
     * @param Category $item
     * @return array
     */
    protected function field($item)
    {
        return [
            'id'=>$item->getId(),
            'title'=>$item->getTitle(),
            'slug'=>$item->getSlug(),
            'product_count'=>$item->getProducts()->count(),
        ];
    }
}