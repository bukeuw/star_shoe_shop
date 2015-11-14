<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getUserOrder()
    {
        $order = Order::firstOrCreate(['user_id' => \Auth::user()->id]);

        return $order;
    }

    protected function getTotalPrice(Collection $orderItems)
    {
        $total = 0;

        foreach($orderItems as $item) {
            $total += ($item->product->price * $item->qty);
        }

        return $total;
    }

    public function showOrderList()
    {
        $order = $this->getUserOrder();

        $orderItems = $order->orderItems;
        $total = $this->getTotalPrice($orderItems);

        return view('tokostar.order', compact('orderItems', 'total'));
    }

    public function addItem($productId)
    {
        $order = $this->getUserOrder();

        $orderItem = $order->orderItems->where('product_id', $productId)->first();

        if($orderItem) {
            $orderItem->qty += 1;
            $orderItem->save();
        } else {
            $orderItem = new OrderItem();
            $orderItem->product_id = $productId;
            $orderItem->qty = 1;
            $orderItem->order_id = $order->id;
            $orderItem->save();
        }

        return redirect('/order');
    }

    public function updateItem(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $qty = $request->input('qty');

        if($qty <= 0 && $qty > 20) {
            return redirect('/order')
                ->withErrors(['qty' => 'Jumlah beli tidak valid.']);
        }

        $orderItem->update(['qty' => $qty]);

        return redirect('/order');
    }

    public function removeItem($id)
    {
        OrderItem::destroy($id);

        return redirect('/order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderItems = OrderItem::paginate(20);

        return view('tokostar.admin.orderlist', compact('orderItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
