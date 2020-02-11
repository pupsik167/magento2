<?php
declare(strict_types=1);

namespace Transoft\Blog\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Transoft\Blog\Model\ModelRepository;
use Magento\Framework\View\Element\Template;

/**
 * Generates blog list
 */
class SingleBlog extends Template implements ArgumentInterface
{
    /**
     * @var RequestInterface $request
     */
    private $request;

    /**
     * @var ModelRepository
     */
    private $modelRepository;

    /**
     * Creates single blog block
     *
     * @param RequestInterface $request
     * @param ModelRepository $modelRepository
     */
    public function __construct(
        RequestInterface $request,
        ModelRepository $modelRepository
    ) {
        $this->request = $request;
        $this->modelRepository = $modelRepository;
    }

    /**
     * Returns blog id from request
     *
     * @return int
     */
    public function getBlogId()
    {
        return $this->request->getParam('id');
    }

    /**
     * Returns blog by id
     *
     * @param int $id
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getBlogById($id)
    {
        return $this->modelRepository->getById($id);
    }
}
