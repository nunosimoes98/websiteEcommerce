<?php 
use App\Http\Controllers\Controller;
use App\Product;



?>

@extends('layouts.frontLayout.front_design')






@section('content')

  
              <style type="text/css">
  /* Make the container relative */
.swap-on-hover {
  position: relative; 
  margin:  0 auto;
  max-width: 400px;
}

/* Select the image and make it absolute to the container */
.swap-on-hover img {
  position: absolute;
  top:0;
  left:0;
  overflow: hidden;
  /* Sets the width and height for the images*/
  width: 400px;
  height: 400px;
}

/* 
  We set z-index to be higher than the back image, so it's alwyas on the front.

We give it an opacity leaner to .25s, that way when we hover we will get a nice fading effect. 
*/
.swap-on-hover .swap-on-hover__front-image {
  z-index: 9999;
  transition: opacity .5s linear;
  cursor: pointer;
}

/* When we hover the figure element, the block with .swap-on-hover, we want to use > so the front-image is going to have opacity of 0, which means it will be hidden, to the back image will show */
.swap-on-hover:hover > .swap-on-hover__front-image{
  opacity: 0;
}


</style>


   <section class="cat_product_area section_gap">

     
     

    <div class="container">

       



              <div class="row"> 


              @foreach($productsAll as $product)
              <div class="col-sm-6 col-md-6 col-lg-4 ftco-animate">
                <div class="product">
                  <a href="{{url('product/'.$product->id)}}" class="img-prod"><img class="img-fluid" src="{{ asset('/images/backend_images/products/medium/'.$product->image)}}" alt="Colorlib Template">
                    <div class="overlay"></div>
                  </a>
                  <div class="">
                  <br>
                  <h4 style="text-align: center; color: #000000; font-style: bold;">{{ $product->product_name}}</h4>
                  <h5 style="text-align: center; color: #5c5c3d; ">{{ $product->price}} €</h5> 
                  <br>
                  </div>
                </div>
              </div>
              @endforeach

            </div>

        </div>
         
  </section>


 

    @endsection

