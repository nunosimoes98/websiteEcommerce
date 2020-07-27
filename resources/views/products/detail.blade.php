<?php 
use App\Product;
use Carbon\Carbon;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;

 ?>

@extends('layouts.frontLayout.front_design')

@section('content')

<style type="text/css">
    .accordion-area {
    margin-top: 50px;
    border-top: 2px solid #e1e1e1;
}

.accordion-area .panel {
    border-bottom: 2px solid #e1e1e1;
}

.accordion-area .panel-link {
    background-image: url("../img/arrow-down.png");
    background-repeat: no-repeat;
    background-position: right 10px top 30px;
}

.faq-accordion.accordion-area .panel-link,
.faq-accordion.accordion-area .panel-link.active.collapsed {
    padding: 17px 100px 17px 20px;
}

.faq-accordion.accordion-area .panel-link:after {
    right: 44px;
}

.accordion-area .panel-header .panel-link.collapsed {
    background-image: url("../img/arrow-down.png");
}

.accordion-area .panel-link.active {
    background-image: url("../img/arrow-up.png");
}

.accordion-area .panel-link.active {
    background-color: transparent;
}

.accordion-area .panel-link,
.accordion-area .panel-link.active.collapsed {
    text-align: left;
    position: relative;
    width: 100%;
    font-size: 14px;
    font-weight: 700;
    color: #414141;
    padding: 0;
    text-transform: uppercase;
    line-height: 1;
    cursor: pointer;
    border: none;
    min-height: 69px;
    background-color: transparent;
    border-radius: 0;
}

.accordion-area .panel-body {
    padding-top: 10px;
}

.accordion-area .panel-body p {
    color: #8f8f8f;
    margin-bottom: 25px;
    line-height: 1.8;
}

.accordion-area .panel-body p span {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #f51167;
}

.accordion-area .panel-body img {
    margin-bottom: 25px;
}

.accordion-area .panel-body h4 {
    font-size: 18px;
    margin-bottom: 20px;
}

</style>


    <br>
    <br>


    <!--================Single Product Area =================-->
    <div class="product_image_area">

        <div class="container">
             @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif  
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_product_img">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" >
                                    <img src="{{ asset('/images/backend_images/products/small/'.$productDetails->image)}}" alt="" style="width: 60px; height:60px; ">
                                </li>
                                @foreach($productAltImages as $altimg)
                                <li data-target="#carouselExampleIndicators" data-slide-to="1">
                                    <img src="{{ asset('images/backend_images/products/small/'.$altimg->image) }}" alt="" style="width: 60px; height: 60px; ">
                                </li>
                                @endforeach

                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ asset('/images/backend_images/products/medium/'.$productDetails->image)}}" alt="First slide">
                                </div>
                                @foreach($productAltImages as $altimg)
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('images/backend_images/products/medium/'.$altimg->image) }}" alt="Second slide">
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-5 offset-lg-1">
                    <form name="addtoCartForm" id="addtoCartForm" action="{{ url('add-cart') }}" method="post">{{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                                <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                                <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                                <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">
                    <div class="s_product_text">
                        <h3>{{ $productDetails->product_name}}</h3>

                        <h2>{{ $productDetails->price}}€ </h2>
                        <h5>
                            <?php
                            $exchangeRates = new ExchangeRate();
                            echo $exchangeRates->convert($productDetails->price, 'EUR', 'GBP', Carbon::now());
                            ?>£
                        </h5>
                        <h5>
                            <?php
                            $exchangeRates = new ExchangeRate();
                            echo $exchangeRates->convert($productDetails->price, 'EUR', 'USD', Carbon::now());
                            ?>$
                        </h5>
                        
                        
                        <ul class="list">

                            <li>
                                <a href="#">
                                    <span>Availibility</span><span id="Availability"> @if($total_stock>0) In Stock @else Out Of Stock @endif </span></a>
                            </li>
                           
                        </ul>
                        
                            <div class="form-group d-flex">
                                    <div class="select-wrap">
                                        
                                          <p>
                                            <select id="selSize" name="size" style="width:150px;" class="form-control" required>
                                                <option value="">Select</option>
                                                @foreach($productDetails->attributes as $sizes)
                                                @if($sizes->stock > 0)
                                                    <option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}</option>
                                                @endif
                                                @endforeach
                                            </select>   
                                           </p>
                                        </div>
                                    </div>
                                </div>
                        <div class="product_count">
                            <label for="qty">Quantity:</label>
                            <input type="text" name="quantity" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                             class="increase items-count" type="button">
                                <i class="lnr lnr-chevron-up"></i>
                            </button>
                            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                             class="reduced items-count" type="button">
                                <i class="lnr lnr-chevron-down"></i>
                            </button>
                        </div>
                        
                    <br>
                        <div class="card_area">
                             
                                <div class="sharethis-inline-share-buttons"></div>
                                <br>
             
                                <br>
                            <button type="submit" class="genric-btn success-border circle" id="wishListButton" name="wishListButton" value="Wish List">Add to Wish</button> 
                            @if($total_stock>0)
                            <button type="submit" class="genric-btn success circle" id="cartButton" name="cartButton" value="Shopping Cart">Add to Cart</button>
                            @endif
                            
  
                                
                            </a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="accordion" class="accordion-area">
                        @if(!empty($productDetails->description))
                        <div class="panel">
                            <div class="panel-header" id="headingOne" >
                                <button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="text-align: center;">Description</button>
                            </div>
                            <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="panel-body">
                                    <p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($productDetails->material))
                        <div class="panel">
                            <div class="panel-header" id="headingTwo">
                                <button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2" style="text-align: center;">Material </button>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="panel-body">
                                    <img src="./img/cards.png" alt="">
                                    <p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($productDetails->video))
                        <div class="panel">
                            <div class="panel-header" id="headingTwo">
                                <button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2" style="text-align: center;">Video </button>
                            </div>
                            <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      


                                    <div class="col-sm-12">
                                        <video controls width="640" height="480" style="display:block; margin: 0 auto;">
                                          <source src="{{ url('videos/'.$productDetails->video)}}" type="video/mp4">
                                        </video>
                                    </div>

                            </div>
                        </div>
                        @endif
                       
                    </div>
    </div>

    
    

    <script type="text/javascript">
        $(document).ready(function(){
            $("#selSize").change(function(){
            var idsize = $(this).val();
            if(idsize==""){
                return false;
            }
            $.ajax({
                type:'get',
                url:'/get-product-price',
                data:{idsize:idsize},
                success:function(resp){
                    var arr = resp.split('#');

                    $("#getPrice").html("EUR "+arr1[0]);
                    $("#price").val(arr[0]);

                    if(arr[1]==0){
                        $("#cartButton").hide();
                        $("#Availability").text("Out Of Stock");
                    }else{
                        $("#cartButton").show();
                        $("#Availability").text("In Stock");
                    }
                    
                    
                },error:function(){
                    alert("Error");
                }
            });
            });
            });

        function checkPincode(){
        var pincode = $("#chkPincode").val();

        if(pincode==""){
            alert("Please enter Pincode"); return false;    
        }
        $.ajax({
        type:'post',
        data:{pincode:pincode},
        url:'/check-pincode',
        success:function(resp){
            if(resp>0){
                $("#pincodeResponse").html("<font color='green'>This pincode is available for delivery</font>");
            }else{
                $("#pincodeResponse").html("<font color='red'>This pincode is not available for delivery</font>");  
            }
        },error:function(){
            alert("Error");
        }
        });
        }
    
    </script>
      <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <script>tinymce.init({selector:'textarea'});</script>
    @endsection