<?php

namespace App\Utilities;

use Auth;
use App\Payment;
use App\Product;
use App\CartItem;
use App\Transaction;
use App\TransactionDetail;

trait PaymentUtil
{
	/**
	 * Get the billable object
	 * 
	 * @return \App\User
	 */
	protected function getUser()
	{
		return Auth::user();
	}

	/**
	 * Create invoice for each item in user cart
	 * 
	 * @param  string $paymentMethod
	 * @return \Stripe\Invoice
	 */
	protected function createInvoice($paymentMethod, $options = [])
	{
		$user = $this->getUser();

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

		if($paymentMethod == 'Transfer Bank') {
        	Payment::create(array_merge(['transaction_id' => $transaction->id], $options));
        }

		foreach($cartItems as $cartItem) {
			TransactionDetail::create([
				'transaction_id' => $transaction->id,
				'product_id' => $cartItem->product->id,
				'quantity' => $cartItem->qty,
			]);

			Product::find($cartItem->product->id)->decrement('stock', $cartItem->qty);
			
			CartItem::destroy($cartItem->id);
		}

		// return $invoice;
	}

	protected function handleCreditCardPayment($token, $options = [])
	{	
		$user = $this->getUser();
		
		if(!$user->subscribed()) {
			$user->subscription('member')->create($token, $options);
		} else {
			$user->updateCard($token);
		}

		$this->createInvoice('Kartu Kredit');
	}

	protected function handleBankTransferPayment($options = [])
	{
		$this->createInvoice('Transfer Bank', $options);
	}
}