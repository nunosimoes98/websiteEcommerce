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
		<div class="container">
			
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="{{ asset('images/frontend_images/login.jpg') }}" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>Login to be able to make your purchases with us!</p>
							<a class="main_btn" href="{{ url('/regist') }}">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" action="{{ url('/user-login') }}" method="post" id="loginForm" name="loginForm">
							{{ csrf_field() }}
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" name="email" placeholder="Insert email" required="">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" name="password" placeholder="Password" required="">
							</div>
							<!--<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>-->
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="btn submit_btn">Log In</button>
								<a href="{{ url('/forgot-password') }}">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->



  
  @endsection
  
