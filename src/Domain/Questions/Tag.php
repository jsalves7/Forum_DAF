<?php

namespace App\Domain\Questions;

use App\Domain\Questions\Tag\TagId;
use App\Domain\Stringable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Tag
 *
 * @package App\Domain\Questions
 *
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema()
 */
class Tag implements Stringable, \JsonSerializable
{

    /**
     * @var TagId
     *
     * @ORM\Id()
     * @ORM\Column(type="TagId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Tag identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $tagId;

    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag description"
     * )
     */
    private $description;

    /**
     * Creates a Tag
     *
     * @param string $description
     * @throws Exception
     */
    public function __construct(string $description)
    {
        $this->description = $description;
        $this->tagId = new TagId();
    }

    /**
     * tagId
     *
     * @return TagId
     */
    public function tagId(): TagId
    {
        return $this->tagId;
    }

    /**
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * Returns a text version of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->description;
    }

    /**
     * Specifies data to be serialized to json
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'tagId' => $this->tagId,
            'description' => $this->description
        ];
    }
}
