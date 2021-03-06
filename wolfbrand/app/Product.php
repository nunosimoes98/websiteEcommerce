<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Storage;
use Session;

class Product extends Model
{
   protected $table = 'products';
   
	public function attributes(){
		return $this->hasMany('App\ProductAttribute', 'product_id');
	}

	public static function cartCount(){
		if(Auth::check()){
			//utilizador logado, vamos usar autenticação
			$user_email = Auth::user()->email;
			$cartCount = DB::table('cart')->where('user_email', $user_email)->sum('quantity');
		}else{
			//utilizador não logado, vamos usar sessão
			$session_id = Session::get('session_id');
			$cartCount = DB::table('cart')->where('session_id', $session_id)->sum('quantity');
		}

		return $cartCount;
	}

	public static function productCount($cat_id){
		$catCount = Product::where(['category_id'=>$cat_id])->count();
		return $catCount;
	}

    public static function getProductStock($product_id,$product_size){
        $getProductStock = ProductAttribute::select('stock')->where(['product_id'=>$product_id,'size'=>$product_size])->first();
        return $getProductStock->stock;
    }

    public static function getProductPrice($product_id,$product_size){
        $getProductPrice = ProductAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$product_size])->first();
        return $getProductPrice->price;
    }

    public static function deleteCartProduct($product_id,$user_email){
        DB::table('cart')->where(['product_id'=>$product_id,'user_email'=>$user_email])->delete();
    }

    public static function getProductStatus($product_id){
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }

    public static function getCategoryStatus($category_id){
        $getCategoryStatus = Category::select('status')->where('id',$category_id)->first();
        return $getCategoryStatus->status;
    }

    public static function getAttributeCount($product_id,$product_size){
        $getAttributeCount = ProductAttribute::where(['product_id'=>$product_id,'size'=>$product_size])->count();
        return $getAttributeCount;   
    }

    public static function getShippingCharges($total_weight,$country){
        $shippingDetails = ShippingCharge::where('country',$country)->first();
        if($total_weight>0){
            if($total_weight>0 && $total_weight<=500){
                $shipping_charges = $shippingDetails->shipping_charges0_500g;
            }else if($total_weight>=501 && $total_weight<=1000){
                $shipping_charges = $shippingDetails->shipping_charges0_1000g;
            }else if($total_weight>=1001 && $total_weight<=2000){
                $shipping_charges = $shippingDetails->shipping_charges1001_2000g;
            }else if($total_weight>=2001 && $total_weight<=5000){
                $shipping_charges = $shippingDetails->shipping_charges2001_5000g;
            }else{
                $shipping_charges = 0;    
            }
        }else{
            $shipping_charges = 0;
        }
        return $shipping_charges;
    }

    public static function getGrandTotal(){
        $getGrandTotal = "";
        $username = Auth::user()->email;
        $userCart = DB::table('cart')->where('user_email',$username)->get();
        $userCart = json_decode(json_encode($userCart),true);

        $priceArray[]= "";

        foreach ($userCart as $product) {
            $productPrice = ProductAttribute::where(['product_id'=>$product['product_id'], 'size'=>$product['size']])->first();
            $priceArray[] = $productPrice->price;
        }


        $grandTotal = array_sum($priceArray) - Session::get('CouponAmount') + Session::get('ShippingCharges');

        return $grandTotal;
    }

    

}