<?php
declare(strict_types=1);

namespace Transoft\HelloWorldAPI\Api\Data;

interface HelloWorldInterface
{
    const ID = 'id';
    const CONTENT = 'content';

    /**
     * Return hello ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set hello ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id) : HelloWorldInterface;

    /**
     * Return the Content
     *
     * @return string
     */
    public function getContent() : string;

    /**
     * Set the Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content) : HelloWorldInterface;
}
