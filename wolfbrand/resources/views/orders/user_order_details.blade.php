@extends('layouts.frontLayout.front_design')

@section('content')

<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
					
				</div>
			</div>
		</div>
	</section>

<div class="whole-wrap">
		<div class="container">
			<div class="section-top-border">
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="percentage">Product Code</div>
							<div class="percentage">Product Name</div>
							<div class="percentage">Product Size</div>
							<div class="percentage">Product Color</div>
							<div class="percentage">Product Size</div>
							<div class="percentage">Product Qty</div>
						</div>
						@foreach($orderDetails->orders as $pro)
						<div class="table-row">
							<div class="visit">{{ $pro->product_code }}</div>
							<div class="visit">{{ $pro->product_name }}</div>
							<div class="visit">{{ $pro->product_size }}</div>
							<div class="visit">{{ $pro->product_color }}</div>
							<div class="visit">{{ $pro->product_price }}</div>
							<div class="visit">{{ $pro->product_qty }}</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection