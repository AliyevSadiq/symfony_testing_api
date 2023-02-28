<?php


namespace App\Requests;
use App\Entity\Category;
use App\Entity\Product;
use App\Validator\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateRequest extends BaseRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'Title is required')]
    public string $title;

    #[Assert\Type('bool')]
    public bool $is_show;


    #[Assert\NotBlank(message: 'Description is required')]
    public string $description;


    #[Assert\NotBlank(message:'Category is required')]
    #[EntityExist(className: Category::class,message: 'Category not exists')]
    public  $category_id;


    #[Assert\NotBlank(message:'Price is required')]
    #[Assert\GreaterThanOrEqual('1')]
    public float $price;

    public ?Product $product=null;
}