<?php

namespace App\DTO\Response\Transformer;

use App\DTO\Response\CategoryResponseDTO;
use App\Entity\Category;
use JetBrains\PhpStorm\Pure;

class CategoryResponseDtoTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @param Category $category
     * @return CategoryResponseDTO
     */
    #[Pure] public function transformerFromObject($category): CategoryResponseDTO
    {
        $dto = new CategoryResponseDTO();
        $dto->id = $category->getId();
        $dto->title = $category->getTitle();
        $dto->active = $category->isIsActive();

        return $dto;
    }
}