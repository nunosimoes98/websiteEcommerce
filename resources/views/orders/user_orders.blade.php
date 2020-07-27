@extends('layouts.frontLayout.front_design')

@section('content')

<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
					<h2>Elements</h2>
					<div class="page_link">
						<a href="index.html">Home</a>
						<a href="elements.html">Elements</a>
					</div>
				</div>
			</div>
		</div>
	</section>

<div class="whole-wrap">
		<div class="container">
			<div class="section-top-border">
				<h3 class="mb-30 title_color">Table</h3>
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="percentage">Order ID</div>
							<div class="percentage">Ordered Products</div>
							<div class="percentage">Payment Method</div>
							<div class="percentage">Grand Total</div>
							<div class="percentage">Created On</div>
		
						</div>
						@foreach($orders as $order)
						<div class="table-row">
							<div class="visit"><a href="{{url('/orders/'.$order->id)}}">{{ $order->id }}</a></div>
							<div class="visit">
								@foreach($order->orders as $pro)
								{{ $pro->product_code }}<br>
								@endforeach
							</div>
							<div class="visit">{{ $order->payment_method}}</div>
							<div class="visit">{{ $order->grand_total}}</div>
							<div class="visit">{{ $order->created_at}}</div>
						
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection