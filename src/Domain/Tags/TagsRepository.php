<?php


namespace App\Domain\Tags;



use Doctrine\Common\Collections\Collection;

interface TagsRepository
{
    /**
     * Adds a tag to the tag repository
     *
     * @param Tag $tag
     *
     * @return Tag
     */
    public function add(Tag $tag): Tag;

    /**
     * Removes a tag from repository
     *
     * @param Tag $tag
     */
    public function remove(Tag $tag): void;

    /**
     * Returns a collection of tags entities based on description's list passed as argument
     *
     * If the tag does not exist it will be created, return the existent tag otherwise
     *
     * @param array $tags
     *
     * @return Collection
     */
    public function getList(array $tags): Collection;

    /**
     * Retrieves the tag that has the provided description
     *
     * @param string $description
     *
     * @return Tag|null
     */
    public function withDescription(string $description): ?Tag;

}