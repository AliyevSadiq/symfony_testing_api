<?php


namespace App\Requests;
use App\Entity\User;
use App\Validator\Unique;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordRequest extends BaseRequest
{

    #[Assert\NotBlank(message: 'Password is required')]
    public string $password;

}