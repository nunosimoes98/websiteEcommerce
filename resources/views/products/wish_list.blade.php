@extends('layouts.frontLayout.front_design')

<?php use App\Product; ?>
@section('content')



    

        <!--================Home Banner Area =================-->
	<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
					<h2>My Wish</h2>
					<div class="page_link">
						<a href="/">Home</a>
						<a href="{{url('/cart')}}">Cart</a>
					</div>
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
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php $total_amount = 0; ?>
							@foreach($userWishList as $wish)
							
							<tr>
								<td>
									<div class="media">
										<div class="d-flex">
											<img style="width:100px;" src="{{ asset('/images/backend_images/products/small/'.$wish->image) }}" alt="">
										</div>
										<div class="media-body">
											<p>{{ $wish->product_name }} | Product Code: {{ $wish->product_code }}</p>
										</div>
									</div>
								</td>
								<td>
									<?php $product_price = Product::getProductPrice($wish->product_id,$wish->size); ?>
									<h5>{{ $product_price }} €</h5>
								</td>
								<form name="addtoCartForm" id="addtoCartForm" action="{{ url('add-cart') }}" method="post">{{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $wish->id }}">
                                <input type="hidden" name="product_name" value="{{ $wish->product_name }}">
                                <input type="hidden" name="product_code" value="{{ $wish->product_code }}">
                                <input type="hidden" name="product_color" value="{{ $wish->product_color }}">
                                <input type="hidden" name="size" value="{{ $wish->id }}-{{ $wish->size }}">
                                <input type="hidden" name="price" id="price" value="{{ $wish->price }}">
								<td>

									<a href="{{url('/product/'.$wish->product_id)}}" class="genric-btn success-border circle">Details</a>

								</td>
								</form>
								<td>
									<a class="cart_quantity_delete" href="{{ url('/wish-list/delete-product/'.$wish->id) }}"><i class="fa fa-times"></i></a>
								</td>

							</tr>
							<?php $total_amount = $total_amount + ($product_price*$wish->quantity); ?>
							@endforeach

							
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