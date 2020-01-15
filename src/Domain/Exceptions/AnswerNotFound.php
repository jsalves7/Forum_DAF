<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class AnswerNotFound extends RuntimeException implements DomainException
{

}