<?php

namespace App\Utilities;

use Auth;
use App\Product;
use Laravel\Cashier\StripeGateway;
use Stripe\Invoice as StripeInvoice;
use Laravel\Cashier\Contracts\Billable;
use Stripe\InvoiceItem as StripeInvoiceItem;

trait PaymentUtil
{
	/**
	 * Get the billable object
	 * 
	 * @return \Laravel\Cashier\Contracts\Billable
	 */
	protected function getBillable()
	{
		return Auth::user();
	}

	/**
	 * Create invoice for each item in user cart
	 * 
	 * @param  \Billable $user
	 * @return \Stripe\Invoice
	 */
	protected function createInvoice(Billable $user)
	{
		//$invoice = StripeInvoice::create(['customer' => $user->getStripeId()], $user->getStripeKey());

		foreach($user->cart->cartItems as $cartItem) {
			StripeInvoiceItem::create([
				'customer' => $user->getStripeId(), 
				'amount' => ($cartItem->product->price * $cartItem->qty) * 100,
				'currency' => 'idr',
				'description' => $cartItem->product->qty . ' ' . $cartItem->product->unit . ' ' . $cartItem->product->name],
				$user->getStripeKey()
			);
			
			CartItem::destroy($cartItem->id);
		}

		// return $invoice;
	}

	protected function handleCreditCardPayment($token, $options = [])
	{
		$billable = $this->getBillable();
		
		if(!$billable->stripeIsActive()) {
			$billable->subscription('member')->create($token, $options);
		}

		$this->createInvoice($billable);
	}

	protected function handleBankTransferPayment($options = [])
	{
		if(!$billable->stripeIsActive()) {
			$billable->subscription('member')->create('', $options);
		}

		$this->createInvoice($billable);
	}
}