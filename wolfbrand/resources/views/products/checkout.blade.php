@extends('layouts.frontLayout.front_design')

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


	<div class="whole-wrap">
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

    		

			<div class="section-top-border">
				<div class="row">
					<div class="col-md-3">
                                <div class="blog_info text-right">
                                    <div class="post_tag">
                                        
                                    </div>

                                </div>
                            </div>
					<div class="col-lg-6">
						<h3 class="mb-30 title_color" style="text-align: center;">Shipping Details</h3>
						<form action="{{url('/checkout')}}" method="post">
							{{ csrf_field() }}
							<div class="mt-10">
								<input type="text" class="form-control" id="shipping_name" name="shipping_name" @if(!empty($shippingDetails->name))value="{{ $shippingDetails->name }}" @endif placeholder="Name">
							</div>
							<div class="mt-10">
								<input type="text" class="form-control" id="shipping_address" name="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif placeholder="Address">
							</div>
							<div class="mt-10">
								<input type="text" class="form-control" id="shipping_city" name="shipping_city" @if(!empty($shippingDetails->city))value="{{ $shippingDetails->city }}" @endif placeholder="City">
							</div>
							<div class="mt-10">
								<input type="text" class="form-control" id="shipping_state" name="shipping_state" @if(!empty($shippingDetails->state))value="{{ $shippingDetails->state }}" @endif placeholder="State">
							</div>
							<div class="mt-10">
								<select id="shipping_country" name="shipping_country" class="country_select form-select">
										<option value="">Country</option>
										@foreach($countries as $country)
											<option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
										@endforeach
									</select>
							</div>
							<div class="mt-10">
								<input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif type="text" placeholder="Shipping Pincode" class="form-control" />
							</div>
							<div class="mt-10">
								<input type="text" class="form-control" id="shipping_mobile" name="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif placeholder="Mobile Phone">
							</div>
							<br>
							<button class="main_btn" type="submit" >Checkout</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--================End Checkout Area =================-->

	@endsection