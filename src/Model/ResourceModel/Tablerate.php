<?php
namespace Klikealo\Carrier\Model\ResourceModel;


class Tablerate extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('klk_tablerate', 'tablerate_id');
	}
	
}