<?php
declare(strict_types=1);

namespace Transoft\Blog\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Transoft\Blog\Api\Data\BlogInterface;
use Transoft\Blog\Model\BlogRepository;

/**
 * Generates blog list
 */
class SingleBlog extends Template
{
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * Creates single blog block
     *
     * @param Context $context
     * @param RequestInterface $request
     * @param BlogRepository $blogRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        RequestInterface $request,
        BlogRepository $blogRepository,
        array $data = []
    ) {
        $this->request = $request;
        $this->blogRepository = $blogRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns blog id from request
     *
     * @return int
     */
    public function getBlogId() : int
    {
        return (int)$this->request->getParam('id');
    }

    /**
     * Returns blog by id
     *
     * @param int $id
     *
     * @return BlogInterface
     */
    public function getBlogById($id) : BlogInterface
    {
        try {
            $blog = $this->blogRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $this->_logger->warning($e);
        }

        return $blog;
    }
}
