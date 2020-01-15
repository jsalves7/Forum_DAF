<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class InvalidAnswerState extends RuntimeException implements DomainException
{

}