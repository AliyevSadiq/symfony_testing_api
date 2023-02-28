<?php


namespace App\Requests;
use App\Entity\User;
use App\Validator\Unique;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordRequest extends BaseRequest
{

    #[Assert\Email(message: 'Email is invalid')]
    #[Assert\NotBlank(message: 'Email is required')]
    public string $email;

}