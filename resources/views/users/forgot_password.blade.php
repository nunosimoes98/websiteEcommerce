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
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="main_btn" href="{{ url('/regist') }}">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Forgot Password?</h3>
						<form class="row login_form" action="{{ url('/forgot-password') }}" method="post" id="forgotPasswordForm" name="forgotPasswordForm">
							{{ csrf_field() }}
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" name="email" placeholder="Insert email" required="">
							</div>
							
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="btn submit_btn">SEND ME</button>
								<a href="{{ url('forgot-password') }}">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>



@endsection