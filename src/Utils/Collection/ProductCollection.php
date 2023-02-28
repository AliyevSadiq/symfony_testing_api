<?php


namespace App\Utils\Collection;

use App\Entity\Category;
use App\Entity\Product;
use App\Utils\Contract\AbstractCollection;

class ProductCollection extends AbstractCollection
{

    /**
     * @param Product $item
     * @return array
     */
    protected static function field($item)
    {
        return [
            'id'=>$item->getId(),
            'title'=>$item->getTitle(),
            'slug'=>$item->getSlug(),
            'is_show'=>$item->isIsShow(),
            'category'=>$item->getCategory()->getTitle(),
        ];
    }
}