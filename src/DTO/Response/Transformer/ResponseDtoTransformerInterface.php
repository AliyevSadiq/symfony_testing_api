<?php

namespace App\DTO\Response\Transformer;

interface ResponseDtoTransformerInterface
{

    public function transformerFromObject($object);
    public function transformerFromObjects(iterable $objects);
}