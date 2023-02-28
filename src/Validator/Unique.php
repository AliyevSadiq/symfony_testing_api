<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Unique extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
    public string $className;
    public string $field;

    #[HasNamedArguments]
    public function __construct(string $className,string $field,string $message, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
        $this->className = $className;
        $this->field = $field;
        $this->message = $message;
    }
}
