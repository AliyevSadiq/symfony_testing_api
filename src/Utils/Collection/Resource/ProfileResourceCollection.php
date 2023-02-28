<?php


namespace App\Utils\Collection\Resource;


use App\Entity\Category;
use App\Entity\User;
use App\Utils\Collection\UserPermissionCollection;
use App\Utils\Contract\AbstractResourceCollection;

class ProfileResourceCollection extends AbstractResourceCollection
{

    /**
     * @param User $item
     * @return array
     */
    protected function field($item)
    {
        return [
            'id'=>$item->getId(),
            'email'=>$item->getEmail(),
            'username'=>$item->getUsername(),
            'roles'=>$item->getRoles()
        ];
    }
}