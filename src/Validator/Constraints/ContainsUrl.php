<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintsUrl extends Constraint
{
    public $message = 'The URL "{{ url }}" is invalid!';
}