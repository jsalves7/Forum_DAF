<?php

namespace App\Domain\Votes;


class Vote implements \JsonSerializable
{

    private $value;

    private CONST POSITIVE = 1;
    private CONST NEGATIVE = 0;

    private function __construct(bool $value)
    {
        $this->value = $value;
    }

    public static function positive(): Vote
    {
        return new Vote (self::POSITIVE);
    }

    public static function negative(): Vote
    {
        return new Vote (self::NEGATIVE);
    }

    public function isPositive(): bool
    {
        return $this->value;
    }

    public function isNegative(): bool
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "vote" => $this->value
        ];
    }
}
