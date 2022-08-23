<?php

namespace App\DTO\Response\Transformer;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{
   public function transformerFromObjects(iterable $objects)
   {
       $dto=[];

       foreach ($objects as $object){
           $dto[]=$this->transformerFromObject($object);
       }

       return $dto;
   }
}