<?php

namespace App\Domain\Tags;

use App\Domain\Tags\Tag\TagId;

class Tag implements \JsonSerializable
{
    /**
     * @var TagId
     */
    private $tagId;

    /**
     * @var string
     */
    private $description;

    /**
     * Tag constructor.
     * @param string $description
     *
     * @throws \Exception
     */
    public function __construct(string $description)
    {
        $this->tagId = new TagId();
        $this->description = $description;
    }

    /**
     * @return TagId
     */
    public function tagId(): TagId
    {
        return $this->tagId;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'tagId' => $this->tagId,
            'description' => $this->description,
        ];
    }
}
