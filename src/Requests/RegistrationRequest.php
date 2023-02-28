<?php


namespace App\Requests;
use App\Entity\User;
use App\Validator\Unique;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationRequest extends BaseRequest
{

    #[Unique(className: User::class,field:'email',message: 'Email already exists')]
    #[Assert\Email(message: 'Email is invalid')]
    #[Assert\NotBlank(message: 'Email is required')]
    public string $email;

    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'Username is required')]
    public string $username;

    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'Password is required')]
    public string $password;
}