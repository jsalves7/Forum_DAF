<?php


namespace App\Domain\Exceptions;


use App\Domain\DomainException;
use RuntimeException;

class InvalidUserVote extends RuntimeException implements DomainException
{

}