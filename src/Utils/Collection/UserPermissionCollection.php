<?php


namespace App\Utils\Collection;

use App\Entity\Category;
use App\Entity\Permission;
use App\Utils\Contract\AbstractCollection;

class UserPermissionCollection extends AbstractCollection
{

    /**
     * @param Permission $item
     * @return array
     */
    protected static function field($item)
    {
        return [
            'id'=>$item->getId(),
            'name'=>$item->getPermissionName(),
        ];
    }
}