<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer\AnswerId;

class EditAnswerCommand
{

    private $answerId;
    private $description;

    public function __construct(AnswerId $answerId, $description)
    {
        $this->answerId = $answerId;
        $this->description = $description;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function description(): string
    {
        return $this->description;
    }
}
