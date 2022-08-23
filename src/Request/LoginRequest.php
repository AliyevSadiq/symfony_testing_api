<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

class LoginRequest extends BaseRequest
{
    #[NotBlank([])]
    #[Email([])]
    public $email;


    #[NotBlank([])]
    public $password;
}