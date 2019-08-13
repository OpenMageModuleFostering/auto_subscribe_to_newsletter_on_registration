<?php
class Oxegena_SubscribeAtCheckout_Model_Observer
{

    public function AssignNewletter(Varien_Event_Observer $observer)
    {
		if (Mage::getStoreConfig('oxegenaconfig_subscribeatcheckout/section_one/subscribe_on_checkout',Mage::app()->getStore()) == 1)
		{
			$event = $observer->getEvent();
			$order = $event->getOrder();
			$Quote = $event->getQuote();
			$request = Mage::app()->getRequest();
			
			$oincid = $order->getIncrementId();
			$salesOrder = Mage::getModel('sales/order')->loadByIncrementId($oincid);

			$email = $salesOrder->getCustomerEmail();
			
			$subscriberModel = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
			if ((!$subscriberModel->isSubscribed()) || (!$subscriberModel->getId())) {
				$status = Mage::getModel('newsletter/subscriber')->subscribe($email);
			}
		}
    }

	public function AssignNewletterFromRegister(Varien_Event_Observer $observer)
    {
		if (Mage::getStoreConfig('oxegenaconfig_subscribeatcheckout/section_one/subscribe_on_register',Mage::app()->getStore()) == 1)
		{
			$event = $observer->getEvent();
			$customer = $event->getCustomer();
			$email = $customer->getEmail();
			
			$subscriberModel = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
			if ((!$subscriberModel->isSubscribed()) || (!$subscriberModel->getId())) {
				$status = Mage::getModel('newsletter/subscriber')->subscribe($email);
			}
		}
    }
	
}
?>