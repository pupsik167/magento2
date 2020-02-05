<?php
declare(strict_types=1);
namespace Transoft\Blog\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Transoft\Blog\Model\ResourceModel\Post as BlogResourceModel;

/**
 * Class BlogRecords
 *
 * Blog records patch class
 */
class BlogRecords implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    protected $moduleDataSetup;

    /**
     * Constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - then under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return void
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();

        $table = $setup->getTable(BlogResourceModel::MAIN_TABLE);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 1,
            'theme' => 'First blog ever',
            'content' => 'This is first blog content',
            'image_url' => 'img/image1.img',
            'creation_time' => '2020-01-27 10:25:25'
        ]);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 2,
            'theme' => 'Second blog',
            'content' => 'This is second blog content',
            'image_url' => 'img/image2.img',
            'creation_time' => '2020-01-28 10:25:25'
        ]);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 3,
            'theme' => 'Third blog',
            'content' => 'This is third blog content',
            'image_url' => 'img/image3.img',
            'creation_time' => '2020-01-28 10:26:26'
        ]);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 4,
            'theme' => 'Fourth blog ever',
            'content' => 'This is fourth blog content',
            'image_url' => 'img/image4.img',
            'creation_time' => '2020-01-27 10:29:29'
        ]);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 5,
            'theme' => 'Fifth blog ever',
            'content' => 'This is fifth blog content',
            'image_url' => 'img/image5.img',
            'creation_time' => '2020-01-27 10:35:35'
        ]);
        $setup->getConnection()->insert($table, [
            'blog_id'=> 6,
            'theme' => 'Sixth blog ever',
            'content' => 'This is sixth blog content',
            'image_url' => 'img/image6.img',
            'creation_time' => '2020-01-27 10:45:45'
        ]);

        $setup->endSetup();
    }
}
