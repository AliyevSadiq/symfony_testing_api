<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

class RegisterRequest extends BaseRequest
{
    #[NotBlank([])]
    #[Email([])]
    #[Unique([])]
    public $email;


    #[NotBlank([])]
    public $password;
}