<?php 
namespace Tests;

use PHPUnit_Framework_TestCase;

class OrderStatus extends \MagicEnum\MagicEnum
{
	const CREATED        = 1;
	const COMPLETE       = 2;
	const CANCELLED      = 3;
	const PROCESSING     = 4;

	// easy way to extend with the status (for labels/translations etc)
	public function getLabel()
	{
		$name = strtolower($this->getName());
		return "order_status.${name}";
	}
}

class Order
{
	/** @var OrderStatus */
	private $status;

	function __construct()
	{
		$this->status = OrderStatus::CREATED();
	}

	public function setStatus(OrderStatus $status)
	{
		$this->status = $status;
	}

	public function setStatusWithNormalization($status)
	{
		if($status instanceof OrderStatus){
			$this->status = $status;
		}else{
			$this->status = new OrderStatus($status);
		}
	}

	public function getStatus()
	{
		return $this->status;
	}
}

class DemoUsageTest extends PHPUnit_Framework_TestCase
{
	public function test_set_status()
	{
		$order = new Order;

		$this->assertEquals(OrderStatus::CREATED(), $order->getStatus());

		$order->setStatus(OrderStatus::CANCELLED());
		
		$this->assertEquals(OrderStatus::CANCELLED(), $order->getStatus());
	}

	public function test_set_normalized_status()
	{
		$order = new Order;
		
		$order->setStatusWithNormalization(OrderStatus::CANCELLED());
		$this->assertEquals(OrderStatus::CANCELLED(), $order->getStatus());

		$order->setStatusWithNormalization(OrderStatus::COMPLETE);
		$this->assertEquals(OrderStatus::COMPLETE(), $order->getStatus());
	}

	public function test_normalization_validates_status()
	{
		$order = new Order;

		$this->setExpectedException(\InvalidArgumentException::class);
		$order->setStatusWithNormalization('asd');
	}

	public function test_extending_status()
	{
		$status = OrderStatus::CANCELLED();

		$this->assertEquals('order_status.cancelled', $status->getLabel());
	}
}

