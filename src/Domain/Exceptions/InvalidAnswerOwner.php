<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class InvalidAnswerOwner extends RuntimeException implements DomainException
{

}