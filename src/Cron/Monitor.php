<?php

namespace Klikealo\Carrier\Cron;

/**
 * 		
 */
class Monitor
{
	private $logger;

	public function __construct(
		\Magento\Sales\Model\Convert\Order $convertOrder,
        \Magento\Shipping\Model\ShipmentNotifier $shipmentNotifier,
        \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory
	)
	{
		$this->_convertOrder = $convertOrder;
        $this->_shipmentNotifier = $shipmentNotifier;

        $this->trackFactory = $trackFactory;
	}

	public function validateStock(\Magento\Sales\Model\Order $order)
	{
		return true;
	}

	public function generateShipment(\Magento\Sales\Model\Order $order, array $tracking = array(),string $sourceId = 'default')
	{
		try{

			$orderShipment = $this->_convertOrder->toShipment($order);

			foreach ($order->getAllItems() AS $orderItem) {

	        	// Check virtual item and item Quantity
	         	if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) continue;

	         	$qty = $orderItem->getQtyToShip();
	         	$shipmentItem = $this->_convertOrder->itemToShipmentItem($orderItem)->setQty($qty);

	         	$orderShipment->addItem($shipmentItem);
	        }

	        $orderShipment->register();
    		$orderShipment->getOrder()->setIsInProcess(true);

    		#obtenemos el source actual de donde obtener el inventario
    		$orderShipment->getExtensionAttributes()->setSourceCode($sourceId);

    		// Save created Order Shipment
            $orderShipment->save();
            $orderShipment->getOrder()->save();

            foreach ($tracking as $itemTracking) {
	            $track = $this->trackFactory->create()->addData(array(
	            	'carrier_code' => isset($itemTracking['carrier_code']) ? $itemTracking['carrier_code'] : 'custom',
				    'title' => $itemTracking['title'],
				    'number' => $itemTracking['number']
	            ));
            	
            	$orderShipment->addTrack($track)->save();
            }

            // Send Shipment Email
            $this->_shipmentNotifier->notify($orderShipment);
            $orderShipment->save();
		}catch(\Exception $e) {
			$order->addStatusHistoryComment("{$e->getMessage()}");
			throw new \Exception($e->getCode(), $e->getMessage());
		}finally {
			$order->save();
		}
	}
}