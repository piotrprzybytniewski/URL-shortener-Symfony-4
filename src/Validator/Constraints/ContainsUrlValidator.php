<?php


namespace App\Validator\Constraints;


use http\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintsUrlValidator extends ConstraintValidator
{


    public function validate($value, Constraint $constraint)
    {
        $regex = "((https?|ftp)://)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=$_.-]+(:[a-z0-9+!*(),;?&=$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9\-\.]*)\.(([a-z]{2,4})|([0-9]{1,3}\.([0-9]{1,3})\.([0-9]{1,3})))"; // Host or IP
        $regex .= "(:[0-9]{2,5})?"; // Port
        $regex .= "(/([a-z0-9+$_%-]\.?)+)*/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+/$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+$%_.-]*)?"; // Anchor



        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'url');
        }

        if (!preg_match('~^$regex$~i', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ url }}', $value)
                ->addViolation();
        }

    }
}