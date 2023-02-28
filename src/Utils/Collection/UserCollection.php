<?php


namespace App\Utils\Collection;

use App\Entity\Category;
use App\Entity\User;
use App\Utils\Contract\AbstractCollection;

class UserCollection extends AbstractCollection
{

    /**
     * @param User $item
     * @return array
     */
    protected static function field($item)
    {
        return [
            'id'=>$item->getId(),
            'email'=>$item->getEmail(),
            'username'=>$item->getUsername(),
        ];
    }
}