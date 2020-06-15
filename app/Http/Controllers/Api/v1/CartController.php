<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Cart;
use App\Product;
use DB;

class CartController extends Controller
{
    // public function addToCart(Request $request, $productId,$accountId)
    // {
    //     $product = Product::find($productId);
    //     $oldCart = Session::has('cart'.$accountId) ? Session::get('cart'.$accountId) :null;
    //     $cart = new Cart($oldCart);
    //     $cart->add($product, $productId);
    //     $request->session()->put('cart'.$accountId,$cart);
        
    //     $cartArray = [];
    //     array_push($cartArray, $cart->items,$cart->totalQuantity,$cart->totalPrice);
    //     return $cartArray;
    // }

    public function addToCart(Request $request, $productId,$accountId)
    {
        $product = Product::find($productId);
        $productArray = ([
            "id"=>$product->id, 
            "riceType"=>$product->riceType , 
            "price"=>$product->price
        ]);

        $arrayObject = (object) $productArray;

        $cart = DB::table('carts')->where('id', $accountId)->first();
        if ($cart) {
            $oldCart = $cart;
            $oldCart->productId = json_decode($oldCart->productId,true);
        }
        else{
            $oldCart = null;
        }
        $newCart = new Cart($oldCart);

        $newCart->add($arrayObject, $productId);

        $output = DB::table('carts')->where('id', $accountId);
        if ($cart == null) {
            $output->insert([
            'id' => $accountId,
            'productId' => json_encode($newCart->productId),
            'totalPrice' => $newCart->totalPrice,
            'totalQuantity' => $newCart->totalQuantity
            ]);
        }
        else{
            $output->update([
            'id' => $accountId,
            'productId' => json_encode($newCart->productId),
            'totalPrice' => $newCart->totalPrice,
            'totalQuantity' => $newCart->totalQuantity
            ]);
        }
        

        return response()->json([$newCart]);

    }

    public function viewCart($id)
    {
        $cart = DB::table('carts')->where('id', $id)->first();
        
        if($cart == null){
            return response()->json(["Cart is currently empty"]);
        }
        else{
            $cart->productId = json_decode($cart->productId);
            return response()->json([$cart]);
        }
        
    }
    // public function viewCart($id)
    // {
        
    //     if(!Session::has('cart'.$id)){
    //         return response()->json(["Cart is currently empty"]);
    //     }
    //     else{
    //         $oldCart = Session::get('cart'.$id);
    //         $cart = new Cart($oldCart);

    //         $cartArray = [];
    //         array_push($cartArray,$cart->items,$cart->totalQuantity,$cart->totalPrice);
    //         return $cartArray;
    //     }
        
    // }
    public function deleteCartItem(Request $request ,$id,$accountId)
    {
        
        $cart = DB::table('carts')->where('id', $accountId)->first();
        $output = DB::table('carts')->where('id', $accountId);
        if ($cart) {
            $oldCart = $cart;
            $oldCart->productId = json_decode($oldCart->productId,true);
        }
        else{
            $oldCart = null;
        }
        if($oldCart->totalQuantity == 1){
            $output->delete();
            return response()->json([]);            
        }

        
        if($oldCart->productId[$id]['quantity'] == 1){
            $oldCart->totalQuantity = $oldCart->totalQuantity-1;
            $oldCart->totalPrice = $oldCart->totalPrice - $oldCart->productId[$id]['price'];

            unset($oldCart->productId[$id]);

            $output->update([
                'id' => $accountId,
                'productId' => json_encode($oldCart->productId),
                'totalPrice' => $oldCart->totalPrice,
                'totalQuantity' => $oldCart->totalQuantity
                ]);
            $cartArray = [];
            return response()->json([]);
        }

        $basePrice = $oldCart->productId[$id]['price']/$oldCart->productId[$id]['quantity'];

        $oldCart->totalQuantity = $oldCart->totalQuantity-1;
        $oldCart->productId[$id]['quantity'] = $oldCart->productId[$id]['quantity']-1;
        $oldCart->productId[$id]['price'] = $oldCart->productId[$id]['price'] - $basePrice;
        $oldCart->totalPrice = $oldCart->totalPrice - $basePrice;
        

        $output->update([
        'id' => $accountId,
        'productId' => json_encode($oldCart->productId),
        'totalPrice' => $oldCart->totalPrice,
        'totalQuantity' => $oldCart->totalQuantity
        ]);
        // $request->session()->put('cart',$oldCart);
        return response()->json([]);
    }
    public function deleteCartItemAll(Request $request, $id,$accountId)
    {
        $cart = DB::table('carts')->where('id', $accountId)->first();
        $output = DB::table('carts')->where('id', $accountId);
        if ($cart) {
            $oldCart = $cart;
            $oldCart->productId = json_decode($oldCart->productId,true);
        }
        else{
            $oldCart = null;
        }

        $oldCart->totalPrice = $oldCart->totalPrice - $oldCart->productId[$id]['price'];
        $oldCart->totalQuantity = $oldCart->totalQuantity - $oldCart->productId[$id]['quantity'];
        unset($oldCart->productId[$id]);

        $output->update([
            'id' => $accountId,
            'productId' => json_encode($oldCart->productId),
            'totalPrice' => $oldCart->totalPrice,
            'totalQuantity' => $oldCart->totalQuantity
        ]);
        
        if($oldCart->productId == null){
            $output->delete();
            // Session::flush();
        }
        return response()->json([]);
    }
    // public function deleteCartItem(Request $request ,$id,$accountId)
    // {
        
    //     $oldCart = Session::has('cart'.$accountId) ? Session::get('cart'.$accountId) :null;

    //     if($oldCart->totalQuantity == 1){
    //         Session::forget('cart'.$accountId);
    //         return response()->json([]);            
    //     }

    //     if($oldCart->items[$id]['quantity'] == 1){
    //         $oldCart->totalQuantity = $oldCart->totalQuantity-1;
    //         $oldCart->totalPrice = $oldCart->totalPrice - $oldCart->items[$id]['price'];
    //         unset($oldCart->items[$id]);
    //         $cartArray = [];
    //         return response()->json([]);
    //     }
    //     $basePrice = $oldCart->items[$id]['price']/$oldCart->items[$id]['quantity'];

    //     $oldCart->totalQuantity = $oldCart->totalQuantity-1;
    //     $oldCart->items[$id]['quantity'] = $oldCart->items[$id]['quantity']-1;
    //     $oldCart->items[$id]['price'] = $oldCart->items[$id]['price'] - $basePrice;
    //     $oldCart->totalPrice = $oldCart->totalPrice - $basePrice;
        
    //     // $request->session()->put('cart',$oldCart);
    //     return response()->json([]);
    // }
    // public function deleteCartItemAll(Request $request, $id,$accountId)
    // {
    //     $oldCart = Session::has('cart'.$accountId) ? Session::get('cart'.$accountId) :null;
    //     $oldCart->totalPrice = $oldCart->totalPrice - $oldCart->items[$id]['price'];
    //     $oldCart->totalQuantity = $oldCart->totalQuantity - $oldCart->items[$id]['quantity'];
    //     unset($oldCart->items[$id]);
    //     if($oldCart->items == null){
    //         Session::forget('cart'.$accountId);
    //         // Session::flush();
    //     }
    //     return response()->json([]);
    // }
}
