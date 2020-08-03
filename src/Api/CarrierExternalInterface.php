<?php
namespace Klikealo\Carrier\Api;

interface CarrierExternalInterface {

	public function init();

	public function createOrder(string $orderId = null);

	public function getTracking(string $orderId = null);
}