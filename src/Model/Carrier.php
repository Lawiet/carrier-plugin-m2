<?php

namespace Klikealo\Carrier\Model;

class Carrier extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'klikealo_carrier';

	protected $_cacheTag = 'klikealo_carrier';

	protected $_eventPrefix = 'klikealo_carrier';

	protected function _construct()
	{
		$this->_init('Klikealo\Carrier\Model\ResourceModel\Carrier');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}