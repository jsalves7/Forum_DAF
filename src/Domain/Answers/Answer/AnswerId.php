<?php

namespace App\Domain\Answers\Answer;


use App\Domain\Comparable;
use App\Domain\Stringable;
use Ramsey\Uuid\Uuid;

class AnswerId implements Stringable, Comparable, \JsonSerializable
{

    private $uuid;

    public function __construct(string $uuidTxt = null)
    {
        $this->uuid = $uuidTxt
            ? Uuid::fromString($uuidTxt)
            : Uuid::uuid4();
    }


    /**
     * Returns the object in text
     *
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->uuid;
    }

    /**
     * Checks if there is other object equal to current one
     *
     * @inheritDoc
     */
    public function equalsTo($other): bool
    {
        if (!$other instanceof AnswerId) {
            return false;
        }

        return $other->uuid->equals($this->uuid);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->uuid;
    }
}
