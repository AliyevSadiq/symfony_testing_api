<?php


namespace App\Utils\Collection;

use App\Entity\Category;
use App\Utils\Contract\AbstractCollection;

class CategoryCollection extends AbstractCollection
{

    /**
     * @param Category $item
     * @return array
     */
    protected static function field($item)
    {
        return [
            'id'=>$item->getId(),
            'title'=>$item->getTitle(),
            'slug'=>$item->getSlug(),
            'is_show'=>$item->isIsShow(),
        ];
    }
}