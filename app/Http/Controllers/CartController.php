<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;
use Cookie;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //dd($cart->all());
        $categories = Category::all();
        return view('frontend.view_cart', compact('categories'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }

    public function updateSidebarNavCart(Request $request)
    {
        if(Session::has('cart')) {
            $total =0;
            $cartQty = count($cart = Session::get('cart'));
            if ( $cartQty> 0){
                foreach ($cart as $key => $cartItem) {
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                }
                return $data = array('total_price'=>$total, 'total_quantity'=> $cartQty);
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function addToCart(Request $request)
    {

            $product = Medicine::find($request->id);

            $data = array();
            $data['id'] = $product->id;
            $tax = 0;
            if ($request->type == "packet"){
                if($product->pack_Price != null ){
                    $data['price'] = packet_price($product->pack_Price);
                }else{
                    $data['price'] = 0;
                }
            }else{
                if($product->single_price != null ){
                    $data['price'] = packet_price($product->single_price);
                }else{
                    $data['price'] = 0;
                }
            }

            $data['quantity'] = intval($request['quantity']);
            $data['tax'] = $tax;
            $data['shipping'] = 0;
            $data['product_referral_code'] = null;
            $data['type'] = $request->type;
            $data['cash_on_delivery'] = $product->cash_on_delivery;
            $data['digital'] = $product->digital;

            if ($request['quantity'] == null){
                $data['quantity'] = 1;
            }

            if($request->session()->has('cart')){
                $foundInCart = false;
                $cart = collect();
                foreach ($request->session()->get('cart') as $key => $cartItem){
                    $cart->push($cartItem);
                }
                if (!$foundInCart) {
                    $cart->push($data);
                }
                $request->session()->put('cart', $cart);
            }else{
                $cart = collect([$data]);
                $request->session()->put('cart', $cart);
            }

        return array('status' => 1, 'view' => view('frontend.partials.addedToCart', compact('product', 'data'))->render());
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        return view('frontend.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));


        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $product = Medicine::find($object['id']);
                    if ($object['quantity'] > 0)
                        $object['quantity'] = $request->quantity;
                    else
                        return false;
            }
            return $object;
        });
        $request->session()->put('cart', $cart);

        return view('frontend.partials.cart_details');
    }
}
