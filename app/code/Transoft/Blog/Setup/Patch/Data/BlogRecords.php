<?php
declare(strict_types=1);

namespace Transoft\Blog\Setup\Patch\Data;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Transoft\Blog\Model\ResourceModel\Post as BlogResourceModel;

/**
 * Blog records patch class
 */
class BlogRecords implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var AdapterInterface */
    private $adapterInterface;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AdapterInterface $adapterInterface
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AdapterInterface $adapterInterface
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->adapterInterface = $adapterInterface;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();

        $table = $setup->getTable(BlogResourceModel::MAIN_TABLE);
        $this->adapterInterface->insertMultiple($table, [
            [
                'theme' => 'First blog ever',
                'content' => 'This is first blog content'
            ],
            [
                'theme' => 'Second blog',
                'content' => 'This is second blog content'
            ],
            [
                'theme' => 'Third blog',
                'content' => 'This is third blog content'
            ],
            [
                'theme' => 'Fourth blog ever',
                'content' => 'This is fourth blog content'
            ],
            [
                'theme' => 'Fifth blog ever',
                'content' => 'This is fifth blog content'
            ],
            [
                'theme' => 'Sixth blog ever',
                'content' => 'This is sixth blog content'
            ]
        ]);

        $setup->endSetup();
    }
}
