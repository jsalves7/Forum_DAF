<?php

namespace App\Domain\Answers\Events;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;

class AnswerWasAccepted extends AbstractDomainEvent implements DomainEvent
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * AnswerWasAccepted constructor.
     *
     * @param AnswerId $answerId
     * @throws \Exception
     */
    public function __construct(AnswerId $answerId)
    {
        parent::__construct();
        $this->answerId = $answerId;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}
