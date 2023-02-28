<?php


namespace App\Requests;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryCreateRequest extends BaseRequest
{


    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'Title is required')]
    public string $title;

    #[Assert\Type('bool')]
    public bool $is_show;


    public ?Category $category=null;
}