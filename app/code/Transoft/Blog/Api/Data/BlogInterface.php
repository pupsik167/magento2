<?php
declare(strict_types=1);

namespace Transoft\Blog\Api\Data;

interface BlogInterface
{
    const BLOG_ID = 'blog_id';
    const THEME = 'theme';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const IMAGE_PATH = 'image_path';

    /**
     * Return the Blog ID
     *
     * @return int
     */
    public function getBlogId();

    /**
     * Set Blog ID
     *
     * @param int $id
     * @return $this
     */
    public function setBlogId($id);

    /**
     * Return the Theme
     *
     * @return string
     */
    public function getTheme();

    /**
     * Set the Theme
     *
     * @param string $theme
     * @return $this
     */
    public function setTheme($theme);

    /**
     * Return the Content
     *
     * @return string
     */
    public function getContent();

    /**
     * Set the Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Return the image path
     *
     * @return string
     */
    public function getImagePath();

    /**
     * Set the image path
     *
     * @param string $imagePath
     * @return $this
     */
    public function setImagePath($imagePath);

    /**
     * Return the Date and Time of blog created
     *
     * @return string
     */
    public function getCreationTime();

    /**
     * Set the Date and Time of blog created
     *
     * @param string $creationTime
     * @return $this
     */
    public function setCreationTime($creationTime);
}
