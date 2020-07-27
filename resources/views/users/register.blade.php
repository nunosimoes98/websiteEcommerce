@extends('layouts.frontLayout.front_design')

@section('content')

			

<section class="login_box_area p_120">
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
			<div class="row">

				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="{{ asset('images/frontend_images/login.jpg') }}" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							
							<a class="main_btn" href="{{ url('/user-register') }}">Proceed to Login</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner reg_form" id="registerForm">
						<h3>Create an Account</h3>
						<form class="row login_form" id="registerForm" name="registerForm" action="{{ url('/login-register')}}" method="POST">
							{{ csrf_field() }}
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name" required="true">
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required="">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="myPassword" name="password" placeholder="Password" minlength="8"required="">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="btn submit_btn">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	
	@endsection