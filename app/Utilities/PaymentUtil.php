<?php

namespace App\Utilities;

use Auth;
use App\Payment;
use App\Product;
use App\CartItem;
use App\Transaction;
use App\TransactionDetail;
use Laravel\Cashier\StripeGateway;
use Laravel\Cashier\Contracts\Billable;

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

	protected function getStripeGateway()
	{
		$billable = $this->getBillable();
		
		return new StripeGateway($billable);
	}

	/**
	 * Create invoice for each item in user cart
	 * 
	 * @param  string $paymentMethod
	 * @return \Stripe\Invoice
	 */
	protected function createInvoice($paymentMethod, options = [])
	{
		$user = $this->getBillable();

		$cart = $this->getUserCart();
        $cartItems = $cart->cartItems;
        $total = $this->getTotalPrice($cartItems);

		$transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->total = $total;
        $transaction->payment_method = $paymentMethod;

        if($paymentMethod == 'Kartu Kredit') {
        	$transaction->confirmed = true;
        }

        $transaction->save();

        Payment::create(array_merge(['transaction_id' => $transaction->id], $options));

		foreach($cartItems as $cartItem) {
			TransactionDetail::create([
				'transaction_id' => $transaction->id,
				'product_id' => $cartItem->product->id,
				'quantity' => $cartItem->qty,
			]);

			Product::find($cartItem->product->id)->decrement('stock', 5);
			
			CartItem::destroy($cartItem->id);
		}

		// return $invoice;
	}

	protected function handleCreditCardPayment($token, $options = [])
	{	
		$user = $this->getBillable();
		$stripeGateway = $this->getStripeGateway();

		if($user->hasStripeId()) {
			$customer = $stripeGateway->createStripeCustomer($token, $options);
		} elseif (! is_null($token)) {
			$stripeGateway->updateCard($token);
		}

		$customer = $stripeGateway->getStripeCustomer($customer->id);
		$stripeGateway->updateLocalStripeData($customer);

		$this->createInvoice('Kartu Kredit');
	}

	protected function handleBankTransferPayment($options = [])
	{
		$this->createInvoice('Transfer Bank', $options);
	}
}