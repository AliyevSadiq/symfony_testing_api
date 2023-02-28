<?php

namespace App\Security\Voter;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PermissionVoter extends Voter
{
    public const CATEGORY_LIST = 'category_list';
    public const CATEGORY_SAVE = 'category_save';
    public const CATEGORY_EDIT = 'category_edit';
    public const CATEGORY_DELETE = 'category_delete';
    public const PRODUCT_LIST = 'product_list';
    public const PRODUCT_SAVE = 'product_save';
    public const PRODUCT_EDIT = 'product_edit';
    public const PRODUCT_DELETE = 'product_delete';


    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute,
                [
                    self::PRODUCT_LIST,
                    self::PRODUCT_SAVE,
                    self::PRODUCT_EDIT,
                    self::PRODUCT_DELETE,
                    self::CATEGORY_LIST,
                    self::CATEGORY_SAVE,
                    self::CATEGORY_EDIT,
                    self::CATEGORY_DELETE,
                ])

            && in_array($subject, [Product::class, Category::class]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        } elseif (in_array('ROLE_MODERATOR', $user->getRoles())) {
           return  $user->getPermissions()->filter(function ($data) use ($attribute) {
                return $attribute == $data->getPermissionName();
            })->count()>0;
        }

        return false;
    }
}
