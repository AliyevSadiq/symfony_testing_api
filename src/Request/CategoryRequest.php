<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CategoryRequest extends BaseRequest
{
    #[NotBlank([])]
    public $title;


    #[Type('boolean')]
    public $is_active;
}