<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class InvalidQuestionOwner extends RuntimeException implements DomainException
{

}