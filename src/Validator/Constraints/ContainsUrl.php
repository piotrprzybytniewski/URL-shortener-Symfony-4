<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsUrl extends Constraint
{
    public $message = 'The URL "{{ url }}" is invalid!';
}