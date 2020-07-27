@extends('layouts.frontLayout.front_design')

@section('content')
<?php use App\Order; ?>
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
			<h3 class="title_confirmation">THANK YOU! YOUR ORDER HAS BEEN PLACED!</h3>
			<h3 class="typo-list" style="text-align: center;">Thanks for the payment. We will process your order very soon</h3>
			<h4 class="typo-list" style="text-align: center;">Your order number is {{ Session::get('order_id') }} and total amount paid is INR {{ Session::get('grand_total') }}</h4>
		</div>
	</section>
	@endsection


	
<?php
Session::forget('grand_total');
Session::forget('order_id');
?>