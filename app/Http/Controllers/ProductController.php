<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Illuminate\Support\Facades\DB;
use Session;


class ProductController extends Controller
{
    function index(){
        $data = Product::all();
       return view('product',['products'=>$data]);
    }

    function detail($id){
        $data = Product::find($id);
        return view('detail',['product'=>$data]);
    }

    function search(Request $req)
    {
        $data= Product::where('name', 'like', '%'.$req->input('query').'%')->get();
        if(!$data)
        {
            $data = Product::all();
        }
        return view('search',['products'=>$data]);
    }

    function addToCart(Request $req)
    {
        if($req->session()->has('user'))
        {
            $cart = new Cart;
            $cart->user_id = $req->session()->get('user')['id'];
            $cart->product_id=$req->product_id;
            $cart->save();
            return redirect('/');
        }
        else{
            return redirect('/login');
        }

    }

    static function cartItem()
    {
        $userId= Session::get('user')['id'];
        return Cart::where('user_id',$userId)->count();
    }
    function cartList()
    {
        if(Session::has('user'))
        {
            $userId= Session::get('user')['id'];
            $data=  DB::table('cart')
            ->join('products','cart.product_id','products.id')
            ->select('products.*','cart.id as cart_id')
            ->where('cart.user_id',$userId)
            ->get();

            return view('cartlist',['products'=>$data]);
        }else{
            return redirect('/login');
        }
    }

    function removecart($id)
    {
        if(Session::has('user'))
        {
            Cart::destroy($id);
            return redirect('cartlist');
        }else{
            return redirect('/login');
        }
    }

    function orderNow()
    {
        if(Session::has('user'))
        {
            $userId= Session::get('user')['id'];
            $data=  DB::table('cart')
            ->join('products','cart.product_id','products.id')
            ->select('products.*','cart.id as cart_id')
            ->where('cart.user_id',$userId)
            ->get();
            $total =  $this->getTotal($userId);
            return view('ordernow',['total'=>$total,'products'=>$data]);
            }else{
            return redirect('/login');
        }
    }

    function getTotal($userId)
    {
        $total = DB::table('cart')
        ->join('products','cart.product_id','products.id')
        ->where('cart.user_id',$userId)
        ->sum('products.price');
        return $total;
    }

    function orderPlace(Request $req)
    {
        $validatedData = $req->validate([
            'address' => 'required',
        ], [
            'address.required' => 'Address is required',
        ]);


        $userId= Session::get('user')['id'];
        if($userId)
        {
            $allCart=Cart::where('user_id',$userId)->get();
            foreach($allCart as $cart)
            {
                $order= new Order;
                $order->product_id=$cart['product_id'];
                $order->user_id=$cart['user_id'];
                $order->address=$req->address;
                $order->status="pending";
                $order->payment_method=$req->payment;
                $order->payment_status="pending";
                $order->created_at = now();
                $order->save();
            }
            Cart::where('user_id',$userId)->delete();
        }
        return redirect('/');
    }

    function myOrder()
    {
        $userId= Session::get('user')['id'];
        $orders= DB::table('orders')
          ->join('products','orders.product_id','products.id')
          ->where('orders.user_id',$userId)
          ->get();
 
          return view('myorder',['orders'=>$orders]); 

        
    }
}
