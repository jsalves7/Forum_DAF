<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class InvalidQuestionState extends RuntimeException implements DomainException
{

}