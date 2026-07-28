<?php

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    /**
     * @var ?ObjectStorage<Post>
     */
    public ?ObjectStorage $posts = null;

    /**
     * Adds a post to this blog
     */
    public function addPost(Post $post): void
    {
        $this->posts?->attach($post);
    }

    /**
     * Remove a post from this blog
     */
    public function removePost(Post $postToRemove): void
    {
        $this->posts?->detach($postToRemove);
    }

    /**
     * Returns all posts in this blog
     *
     * @return ObjectStorage<Post>
     */
    public function getPosts(): ObjectStorage
    {
        return $this->posts;
    }

    /**
     * @param ObjectStorage<Post> $posts
     */
    public function setPosts(ObjectStorage $posts): void
    {
        $this->posts = $posts;
    }
}
