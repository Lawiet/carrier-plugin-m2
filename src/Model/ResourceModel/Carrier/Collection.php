<?php
namespace Klikealo\Carrier\Model\ResourceModel\Carrier;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'carrier_id';
	protected $_eventPrefix = 'klikealo_carrier_collection';
	protected $_eventObject = 'carrier_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Klikealo\Carrier\Model\Carrier', 'Klikealo\Carrier\Model\ResourceModel\Carrier');
	}

	public function filterTableRatesByCarrierCode(string $carrierCode)
	{
		$this->getSelect()->join(
            array('kctr' => $this->getTable('klk_carrier_tablerate')),
            'main_table.carrier_id = kctr.carrier_id',
            array(
                'carrier_code' => 'main_table.code'
            )
            );
        $this->getSelect()->join(
            array('tr' => $this->getTable('klk_tablerate')),
            'tr.tablerate_id = kctr.tablerate_id',
            array(
                'tablerate_id' => 'tr.tablerate_id'
            )
        );
        
        $this->getSelect()->where("main_table.code = '{$carrierCode}'");
        return $this;
	}

	public function filterTablerates(string $carrierCode, array $tablerateOptions)
	{
		$selectFields = array();

		foreach ($tablerateOptions as $field => $value) {
			$selectFields[$field] = "tr.{$field}";
		}

		$this->getSelect()->join(
            array('kctr' => $this->getTable('klk_carrier_tablerate')),
            'main_table.carrier_id = kctr.carrier_id',
            array(
                'carrier_code' => 'main_table.code'
            )
            );
        $this->getSelect()->join(
            array('tr' => $this->getTable('klk_tablerate')),
            'tr.tablerate_id = kctr.tablerate_id',
            array_merge(array(
            	'tablerate_id' => 'tr.tablerate_id'
            ), $selectFields)
        );

        foreach ($tablerateOptions as $field => $condition) {
        	$this->getSelect()->where("tr.{$field} {$condition}");
        }
        
        return $this;
	}

}