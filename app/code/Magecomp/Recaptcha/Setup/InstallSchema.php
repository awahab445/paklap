<?php
namespace Magecomp\Recaptcha\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
    	$installer->getTable('recaptcha')
		)->addColumn(
			'contact_id',
			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
			null,
			['identity' => true, 'nullable' => false, 'primary' => true],
			'ID'
		)->addColumn(
			'cname',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Title'
		)->addColumn(
			'cemail',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Title'
		)->addColumn(
			'cmobno',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Title'
		)->addColumn(
			'ccomment',
			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			255,
			['nullable' => false],
			'Title'
		);
		$installer->getConnection()->createTable($table);
 		$installer->endSetup();
	}
}
