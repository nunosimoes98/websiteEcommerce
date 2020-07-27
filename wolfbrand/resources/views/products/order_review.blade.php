@extends('layouts.frontLayout.front_design')

<?php use App\Product; ?>

@section('content')
<!--================Home Banner Area =================-->
	<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
					
				</div>
			</div>
		</div>
	</section>
	<!--================End Home Banner Area =================-->

	<!--================Checkout Area =================-->
	<section class="checkout_area section_gap">
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
			<div class="billing_details">
				<div class="row order_d_inner">
					<div class="col-lg-8">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Price</th>
								<th scope="col">Quantity</th>
								<th scope="col">Total</th>

							</tr>
						</thead>
						<tbody>
							<?php $total_amount = 0; ?>
							@foreach($userCart as $cart)
							
							<tr>
								<td>
									<div class="media">
										<div class="d-flex">
											<img style="width:100px;" src="{{ asset('/images/backend_images/products/small/'.$cart->image) }}" alt="">
										</div>
										<div class="media-body" style="text-align: center;">
											<p>{{ $cart->product_name }} | Product Code: {{ $cart->product_code }}</p>
										</div>
									</div>
								</td>
								<td class="cart_total">
								
									<p class="cart_total_price">{{ $cart->price }}€</p>
								</td>
								<td>
									<div class="cart_quantity_button">
										<p>{{ $cart->quantity }}</p>
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">{{ $cart->price*$cart->quantity }} €</p>
								</td>

							</tr>
							<?php $total_amount = $total_amount + ($cart->price*$cart->quantity); ?>
							@endforeach

							
						</tbody>
					</table>
				
					<div class="details_item">
						<h4>Shipping Details </h4>
						<ul class="list">
							<li>
								<a href="#">
									<span>Name: </span>{{ $shippingDetails->name }}</a>
							</li>
							<li>
								<a href="#">
									<span>Address: </span>{{ $shippingDetails->address }}</a>
							</li>
							<li>
								<a href="#">
									<span>City</span>{{ $shippingDetails->city }}</a>
							</li>
							<li>
								<a href="#">
									<span>State: </span>{{ $shippingDetails->state }}</a>
							</li>
							<li>
								<a href="#">
									<span>Country: </span>{{ $shippingDetails->country }}</a>
							</li>
							<li>
								<a href="#">
									<span>Postcode: </span>{{ $shippingDetails->pincode }}</a>
							</li>
							<li>
								<a href="#">
									<span>Mobile: </span>{{ $shippingDetails->mobile }}</a>
							</li>
						</ul>
				
				</div>

				</div>
					<div class="col-lg-4">
						<div class="order_box">
							<h2>Your Order</h2>

							<ul class="list list_2">
								<li>
									<a href="#">Subtotal
										<span>{{ $total_amount }} €</span>
									</a>
								</li>
								<li>
									<a href="#">Shipping Cost
										<span>{{ $shippingCharges }} €</span>
									</a>
								</li>
								<li>
									<a href="#">Desconto
										<span>@if(!empty(Session::get('CouponAmount')))
												 {{ Session::get('CouponAmount') }} €
											@else
												0 €
											@endif
										</span>
									</a>
								</li>
								<li>
									<a href="#">Total
										<?php 
										$grand_total = $total_amount + $shippingCharges - Session::get('CouponAmount');  ?>
										<span>{{ $grand_total }} €</span>
										
									</a>
								</li>
							</ul>
							
							<form name="paymentForm" id="paymentForm" action="{{ url('/place-order') }}" method="post"> 
								{{ csrf_field() }}
								<input type="hidden" name="grand_total" value="{{ $grand_total }}">
							<div class="payment_item active">

									@if($prepaidpincodeCount>0)
									<span>
										<label><input type="radio" name="payment_method" id="Paypal" value="Paypal"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png" alt="Credit Card Badges"></label>
									</span>
									<span>
										<label><input type="radio" name="payment_method" id="multibanco" value="multibanco"> <strong>Multibanco</strong></label>
									</span> 
									@endif
								
									<button class="main_btn" type="submit" onclick="return selectPaymentMethod();">Place Order</button>
							</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Checkout Area =================-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
	function selectPaymentMethod(){
	if($('#Paypal').is(':checked') || $('#multibanco').is(':checked')){
	}else{
		alert("Please select Payment Method");
		return false;
	}
}
</script>

	@endsection