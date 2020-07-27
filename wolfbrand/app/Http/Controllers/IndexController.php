<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index($id = null){

    	$productsAll = Product::inRandomOrder()->where('feature_item',1)->get();

    	return view('index')->with(compact('productsAll'));
    }


    

     public function allproducts(){
    	$productsAll = Product::orderBy('id', 'DESC')->get();

    	$categories = Category::where(['parent_id'=>0])->get();



    	return view('allproducts')->with(compact('productsAll', 'categories'));
    }

}
