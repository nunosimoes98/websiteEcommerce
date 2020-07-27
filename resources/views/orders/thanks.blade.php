@extends('layouts.frontLayout.front_design')

@section('content')
<!--================Home Banner Area =================-->
	<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
					<h2>Order Confirmation</h2>
					<div class="page_link">
						<a href="index.html">Home</a>
						<a href="confirmation.html">Confirmation</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Home Banner Area =================-->

	<!--================Order Details Area =================-->
	<section class="order_details p_120">
		<div class="container">
			<div style="margin:0 auto" align=center>
			<h3 class="title_confirmation">THANK YOU! YOUR ORDER HAS BEEN PLACED!</h3>
			<h3 class="typo-list" style="text-align: center;">Your order number is {{ Session::get('order_id') }} and total paypable about is EUR {{ Session::get('grand_total') }}</a></h3>
			<h4 class="typo-list" style="text-align: center;">Please make payment by clicking on below Payment Button</h4>

			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" >
			  <input type="hidden" name="cmd" value="_s-xclick">
			  <input type="hidden" name="business" value="wolfworkbrand@gmail.com">
  			  <input type="hidden" name="item_name" value="{{ Session::get('order_id')}}">
  			  <input type="hidden" name="currency_code" value="EUR">
  			  <input type="hidden" name="amount" value="{{ Session::get('grand_total')}}">
			  <input type="image"  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png" alt="Pay Now">
			  <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
		</div>
	</section>

	@endsection

	<?php
	Session::forget('grand_total');
	Session::forget('order_id');

	?>