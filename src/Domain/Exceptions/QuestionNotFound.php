<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class QuestionNotFound extends RuntimeException implements DomainException
{

}