<?php

namespace App\Http\Controllers;

use Auth;
use App\Cart;
use App\CartItem;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Utilities\PaymentUtil;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class CartController extends Controller
{
    use PaymentUtil;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * retrieve the authenticte user cart or
     * create a new one if doesn't exist
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getUserCart()
    {
        $userCart = Cart::firstOrCreate([
                        'user_id' => Auth::user()->id]);

        return $userCart;
    }

    /**
     * Get the total price of all item in cart
     *
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return int
     */
    protected function getTotalPrice(Collection $cartItems)
    {
        $total = 0;

        foreach($cartItems as $item) {
            $total += ($item->product->price * $item->qty);
        }

        return $total;
    }

    /**
     * Add given product id to user cart
     * 
     * @param int $productId
     */
    public function addItem($productId)
    {
        $cart = $this->getUserCart();

        $cartItem = $cart->cartItems->where('product_id', $productId)->first();

        if($cartItem) {
            $cartItem->qty += 1;
            $cartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->product_id = $productId;
            $cartItem->qty = 1;
            $cartItem->cart_id = $cart->id;
            $cartItem->save();
        }

        return redirect('/cart');
    }

    /**
     * Update specified cart item
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id     
     * @return \Illuminate\Http\Response         
     */
    public function updateItem(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $qty = $request->input('qty');

        if($qty <= 0 && $qty > 20) {
            return redirect('/cart')
                ->withErrors(['qty' => 'Jumlah beli tidak valid.']);
        } else if($qty > $cartItem->product->stock) {
            return redirect('/cart')
                ->withErrors(['qty' => 'Jumlah beli tidak boleh melebihi jumlah stok.']);
        }

        $cartItem->update(['qty' => $qty]);

        return redirect('/cart');
    }

    /**
     * Remove specified item from usr cart
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function removeItem($id)
    {
        CartItem::destroy($id);

        return redirect('/cart');
    }

    public function getCheckout()
    {
        $user = \Auth::user();
        $cart = $this->getUserCart();

        $cartItems = $cart->cartItems;
        
        if(count($cartItems) <= 0) {
            return redirect('/cart');
        }

        if(!$user->profile) {
            \Session::put('needProfile', 'yes');
            return redirect('/member/profile');
        }

        $total = $this->getTotalPrice($cartItems);

        return view('tokostar.checkout', compact('user', 'cartItems', 'total'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = $this->getUserCart();

        $cartItems = $cart->cartItems;
        $total = $this->getTotalPrice($cartItems);

        return view('tokostar.cart', compact('cartItems', 'total'));
    }

    public function paymentBank(Request $request)
    {
        dd($request->all());
    }

    public function paymentCreditCard(Request $request)
    {
        $user = \Auth::user();
        $token = $request->input('stripeToken');

        $this->handleCreditCardPayment($token, ['email' => $user->email]);

        return redirect('/');
    }
}
