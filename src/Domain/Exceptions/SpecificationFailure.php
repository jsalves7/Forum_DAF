<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class SpecificationFailure extends RuntimeException implements DomainException
{

}