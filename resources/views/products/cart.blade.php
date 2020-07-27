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
			@if(Session::has('flash_message_error'))
	            <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
	                <button type="button" class="close" data-dismiss="alert">×</button> 
	                    <strong>{!! session('flash_message_error') !!}</strong>
	            </div>
    		@endif  
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif

	<!--================Cart Area =================-->
	<section class="cart_area">
		<div class="container">
			<div class="cart_inner">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Price</th>
								<th scope="col">Quantity</th>
								<th scope="col">Total</th>
								<th scope="col"></th>
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
										<div class="media-body">
											<p>{{ $cart->product_name }} | Product Code: {{ $cart->product_code }}</p>
										</div>
									</div>
								</td>
								<td>
									<?php $product_price = Product::getProductPrice($cart->product_id,$cart->size); ?>
									<h5>{{ $product_price }}</h5>
								</td>
								<td>
									<div class="cart_quantity_button">
										<a class="cart_quantity_up" href="{{ url('/cart/update-quantity/'.$cart->id.'/1') }}"> + </a>
										<input class="cart_quantity_input" type="text" name="quantity" value="{{ $cart->quantity }}" autocomplete="off" size="2">
										@if($cart->quantity>1)
											<a class="cart_quantity_down" href="{{ url('/cart/update-quantity/'.$cart->id.'/-1') }}"> - </a>
										@endif
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">{{ $cart->price*$cart->quantity }} €</p>
								</td>
								<td class="cart_delete">
									<a class="cart_quantity_delete" href="{{ url('/cart/delete-product/'.$cart->id) }}"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php $total_amount = $total_amount + ($cart->price*$cart->quantity); ?>
							@endforeach

							<tr class="bottom_button">
								<td>
									<a class="gray_btn" href="{{url('/cart')}}">Update Cart</a>
								</td>
								<td>

								</td>
								<td>

								</td>
								<td>
									<div class="cupon_text">
										<form action="{{url('cart/apply-coupon')}}" method="post"> {{ csrf_field() }}
										<input type="text" placeholder="Coupon Code" name="coupon_code">
										<input type="submit" value="Apply" class="main_btn">
										</form>
									</div>
								</td>
							</tr>
							@if(!empty(Session::get('CouponAmount')))
							<tr>
								<td>

								</td>
								<td>

								</td>
								<td>
									<h5>Subtotal</h5>
								</td>
								<td>
									<h5><span><?php echo $total_amount; ?> €</span></h5>
								</td>
							</tr>
							<tr>
								<td>

								</td>
								<td>

								</td>
								<td>
									<h5>Discount</h5>
								</td>
								<td>
									<h5><span>-<?php echo Session::get('CouponAmount'); ?> €</span></h5>
								</td>
							</tr>
							<tr>
								<td>

								</td>
								<td>

								</td>
								<td>
									<h5>Total</h5>
								</td>
								<td>
									<h5><span><?php echo $total_amount - Session::get('CouponAmount'); ?> €</span></h5>
								</td>
							</tr>
							@else
							<tr>
								<td>

								</td>
								<td>

								</td>
								<td>
									<h5>Total</h5>
								</td>
								<td>
									<h5><span><?php echo $total_amount; ?> €</span></h5>
								</td>
							</tr>
							@endif
							
							
							<tr class="out_button_area">
								<td>

								</td>
								<td>

								</td>
								<td>

								</td>
								<td>
									<div class="checkout_btn_inner">
										<a class="gray_btn" href="{{url('/allproducts')}}">Continue Shopping</a>
										<a class="main_btn" href="{{url('/checkout')}}">Proceed to checkout</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>


	<script src="{{ asset('js/frontend_js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/popper.js') }}"></script>
	<script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/stellar.js') }}"></script>
	<script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
	<script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
	<script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
	<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/jquery.ajaxchimp.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/mail-script.js') }}"></script>
	<script src="{{ asset('vendors/jquery-ui/jquery-ui.js') }}"></script>
	<script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script>
	<script src="{{ asset('js/frontend_js/theme.js') }}"></script>

@endsection