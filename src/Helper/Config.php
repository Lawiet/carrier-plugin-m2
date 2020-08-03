<?php

namespace Klikealo\Carrier\Helper;

/**
 * 
 */
class Config
{
	/**
   * @var \Magento\Framework\App\Config\ScopeConfigInterface
   */
   protected $scopeConfig;

   protected $_carrierCode;

   public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
   {
      $this->scopeConfig = $scopeConfig;
   }

   /**
   * Sample function returning config value
   **/

  public function getConfig(string $field) {
    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

    return $this->scopeConfig->getValue("carriers/{$this->_carrierCode}/{$field}", $storeScope);
  }

  public function getConfigMain(string $field)
  {
    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

    return $this->scopeConfig->getValue("klikealo_carrier/carriers/{$field}", $storeScope);
  }

  public function getConfigStore(string $field)
  {
    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

    return $this->scopeConfig->getValue($field, $storeScope);
  }
}