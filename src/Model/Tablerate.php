<?php

namespace Klikealo\Carrier\Model;

class Tablerate extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'klikealo_tablerate';

	protected $_cacheTag = 'klikealo_tablerate';

	protected $_eventPrefix = 'klikealo_tablerate';

	protected function _construct()
	{
		$this->_init('Klikealo\Carrier\Model\ResourceModel\Tablerate');
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