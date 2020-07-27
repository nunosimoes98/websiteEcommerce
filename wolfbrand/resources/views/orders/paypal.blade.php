@extends('layouts.frontLayout.front_design')

@section('content')
<?php use App\Order; ?>
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


	<!--================Order Details Area =================-->
	<section class="order_details p_120">
		<div class="container">
		<div class="heading" align="center">
			<h3 class="title_confirmation">THANK YOU! YOUR ORDER HAS BEEN PLACED!</h3>
			<h3 class="typo-list" style="text-align: center;">Your order number is {{ Session::get('order_id')}} and total paypable about is EUR {{ Session::get('grand_total') }}</a></h3>
			<h4 class="typo-list" style="text-align: center;">Please make payment by clicking on below Payment Button</h4>
			<?php
			$orderDetails = Order::getOrderDetails(Session::get('order_id'));
			$orderDetails = json_decode(json_encode($orderDetails));
			/*echo "<pre>"; print_r($orderDetails); die;*/
			$nameArr = explode(' ',$orderDetails->name);
			if(empty($nameArr[1])){
				$nameArr[1] = "";
			}
			$getCountryCode = Order::getCountryCode($orderDetails->country);
			?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="wolfworkbrand@gmail.com">
				<input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
				<input type="hidden" name="currency_code" value="EUR">
				<input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
				<input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
				<input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
				<input type="hidden" name="address1" value="{{ $orderDetails->address }}">
				<input type="hidden" name="address2" value="">
				<input type="hidden" name="city" value="{{ $orderDetails->city }}">
				<input type="hidden" name="state" value="{{ $orderDetails->state }}">
				<input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
				<input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
				<input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
				<input type="hidden" name="return" value="{{ url('paypal/thanks') }}">
				<input type="hidden" name="cancel_return" value="{{ url('paypal/cancel') }}">
				<input type="hidden" name="notify_url" value="{{ url('/paypal/ipn') }}">
				<input type="image"
				    src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
				  <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif"
				    width="1" height="1">
			</form>
		</div>
	</div>
	</section>

	@endsection

	<?php
	Session::forget('grand_total');
	Session::forget('order_id');

	?>