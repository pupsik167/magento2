<?php
declare(strict_types=1);
namespace Transoft\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * Class InstallSchema
 *
 * Setup InstallSchema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Function install
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('transoft_blog')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('transoft_blog')
            )
                ->addColumn(
                    'blog_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                    ],
                    'Blog ID'
                )
                ->addColumn(
                    'theme',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Blog theme'
                )
                ->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Blog Content'
                )
                ->addColumn(
                    'image_url',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Image url'
                )
                ->addColumn(
                    'creation_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation time'
                )
                ->setComment('Blog Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('transoft_blog'),
                $setup->getIdxName(
                    $installer->getTable('transoft_blog'),
                    ['blog_id'],
                    AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['blog_id'],
                AdapterInterface::INDEX_TYPE_INDEX
            );
        }

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            throw new Zend_Db_Exception('Install schema script should be upgraded');
        }

        $installer->endSetup();
    }
}
