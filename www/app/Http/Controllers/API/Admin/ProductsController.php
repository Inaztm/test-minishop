<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Product;

class ProductsController extends Controller
{

    /**
     * Export products.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $products = Product::all();

        return $products->exportToJson();
    }

    /**
     * Import products.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $json = json_decode($request->file('json'));
        
        Product::importFromJson($json);

        return $json;
    }


    /**
     * Get all products.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function all()
     {
        return Product::all();
     }

     /**
     * Find product.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
     public function find($id)
     {
        return Product::find($id);
     }

    /**
     * Create product.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function create(ProductRequest $request)
     {
        $product = Product::create( $request->only(['name', 'price']) );
 
        return $product;
     }

    /**
     * Update product information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function update(ProductRequest $request, $id)
     {
        $product = Product::find($id);
 
        return tap($product)->update( $request->only(['name', 'price']) );
     }

}
