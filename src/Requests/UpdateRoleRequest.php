<?php


namespace App\Requests;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateRoleRequest extends BaseRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'Role is required')]
    public string $role;

    #[Assert\Type('array')]
    #[Assert\Expression("not (this.getRole() == 'ROLE_MODERATOR' and this.getPermissions() == [])",
    message: "If role = 'ROLE_MODERATOR', permissions should be not null"
    )]
    public  $permissions=[];

    public User $user;


    public function getPermissions(){
        return $this->permissions;
    }

    public function getRole(){
        return $this->role??null;
    }
}