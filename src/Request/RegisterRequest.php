<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterRequest extends BaseRequest
{
    #[NotBlank([])]
    #[Email([])]
    public $email;


    #[NotBlank([])]
    public $password;
}