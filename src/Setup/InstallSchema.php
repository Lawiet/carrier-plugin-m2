<?php

namespace Klikealo\Carrier\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();

		if (!$installer->tableExists('klk_carrier')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('klk_carrier')
			)
				->addColumn(
					'carrier_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Carrier ID'
				)
				->addColumn(
					'name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Carrier Name'
				)
				->addColumn(
					'code',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Carrier Code'
				)
				->addColumn(
					'document',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => true],
					'Carrier Document'
				)
				->addColumn(
					'status',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					1,
					['default' => 1],
					'Post Status'
				)
				->addColumn(
					'created_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
					'Created At'
				)->addColumn(
					'updated_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
					'Updated At')
				->setComment('Klikealo Carriers Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('klk_carrier'),
				$setup->getIdxName(
					$installer->getTable('klk_carrier'),
					['name', 'code', 'document'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['name', 'code', 'document'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);

		}

		if (!$installer->tableExists("klk_tablerate")) {
      		$table = $installer->getConnection()
                ->newTable($installer->getTable("klk_tablerate"))
                ->addColumn(
                    "tablerate_id",
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    array(
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                      ),
                    "Tablerate ID"
                  )
                ->addColumn(
                    "website_id",
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    array(
                        "nullable" => false,
                        "unsigned" => true,
                        "default" => 0
                      ),
                    "Website ID"
                  )
                ->addColumn(
                    "dest_country_id",
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    4,
                    array(
                        "default" => "0",
                        "nullable" => false
                    ),
                    "Country ID"
                  )
                ->addColumn(
                    "dest_region_id",
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    array(
                        "default" => 0,
                        "nullable" => false,
                        "unsigned" => true
                      ),
                    "Region ID"
                  )
                ->addColumn(
                    "dest_zip",
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    array(
                        "default" => "*",
                        "nullable" => false
                      ),
                    "Zipcode"
                  )
                ->addColumn(
                    "dest_ubigeo",
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    array(
                        "default" => "*",
                        "nullable" => true
                      ),
                    "Ubigeo"
                  )
                ->addColumn(
                    "condition_name",
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    array(
                        "default" => "price",
                        "nullable" => false
                      ),
                    "Condition"
                  )
                ->addColumn(
                    "condition_value",
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    "12,4",
                    array(
                        "nullable" => false,
                        "default" => "0.0000"
                      ),
                    "Condition value"
                  )
                ->addColumn(
                    "exceed_value",
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    "12,4",
                    array(
                        "nullable" => true,
                        "default" => "0.0000"
                      ),
                    "Condition value"
                  )                
                ->addColumn(
                    "price",
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    "12,4",
                    array(
                        "nullable" => false,
                        "default" => "0.0000"
                      ),
                    "Price"
                  )
                ->addColumn(
                    "cost",
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    "12,4",
                    array(
                        "nullable" => false,
                        "default" => "0.0000"
                      ),
                    "Cost"
                  )
                ->addForeignKey(
                    $installer->getFkName("klk_tablerate", "dest_country_id", "directory_country", "country_id"),
                    "dest_country_id",
                    $installer->getTable("directory_country"),
                    "country_id",
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                  )
                ->addForeignKey(
                    $installer->getFkName("klk_tablerate", "website_id", "store_website", "website_id"),
                    "website_id",
                    $installer->getTable("store_website"),
                    "website_id",
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                  );

      		$installer->getConnection()->createTable($table);
  		}

		if (!$installer->tableExists('klk_carrier_tablerate')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('klk_carrier_tablerate')
			)
				->addColumn(
					'id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Carrier match Tablerate ID'
				)
				->addColumn(
					'carrier_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
						'index' => true
					],
					'Carrier Id'
				)
				->addColumn(
					'tablerate_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
						'index' => true
					],
					'Carrier Id'
				)
				->addColumn(
					'created_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
					'Created At'
				)->addColumn(
					'updated_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
					'Updated At')
				->addForeignKey(
		            $installer->getFkName(
		                'klk_carrier_tablerate',
		                'carrier_id',
		                'klk_carrier',
		                'carrier_id'
		            ),
		            'carrier_id',
		            $installer->getTable('klk_carrier'), 
		            'carrier_id',
		            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
		        )
		        ->addForeignKey(
		            $installer->getFkName(
		                'klk_carrier_tablerate',
		                'tablerate_id',
		                'klk_tablerate',
		                'tablerate_id'
		            ),
		            'tablerate_id',
		            $installer->getTable('klk_tablerate'), 
		            'tablerate_id',
		            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
		        )
				->setComment('Klikealo Carriers Table');
			$installer->getConnection()->createTable($table);
		}

		$installer->endSetup();
	}
}