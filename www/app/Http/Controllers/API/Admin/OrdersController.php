<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Product;
use App\Order;

class OrdersController extends Controller
{

    /**
     * Export orders.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $orders = Order::all();

        return Order::all()->toJson();
    }

    /**
     * Import orders.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $json = json_decode($request->file('json'));
        
        Order::importFromJson($json);

        return $json;
    }

    /**
     * Get all orders.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function all()
     {
        return Order::with('products')->get();
     }


     /**
     * Find order.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
     public function find($id)
     {
        return Order::find($id);
     }

    /**
     * Create order.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function create(OrderRequest $request)
     {
        $data = $request->only(['name', 'email', 'phone', 'total_price', 'comment']);
        $order = Order::create($data);

        $products = Product::find( $request->input('products') );

        $order->products()->attach($products);
 
        return $order;
     }

    /**
     * Update order information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function update(OrderRequest $request, $id)
     {
        $data = $request->only(['status', 'name', 'email', 'phone', 'total_price', 'comment']);
        $order = Order::find($id);

        $products = Product::find( $request->input('products') );

        $order->products()->attach($products);
 
        return tap($order)->update($data);
     }

}
