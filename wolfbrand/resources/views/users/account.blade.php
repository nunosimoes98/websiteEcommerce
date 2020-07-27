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
	<!-- End Button -->
	<!-- Start Align Area -->
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
					<div class="col-lg-6">
						<h3 class="mb-30 title_color"> Details</h3>
						<form id="accountForm" name="accountForm" action="{{ url('/user-account')}}" method="POST"> {{ csrf_field() }}
							<div class="mt-10">
								<input value="{{$userDetails->name}}" type="text" name="name" id="name" placeholder="Name"
								 required class="single-input">
							</div>
							<div class="mt-10">
								<input value="{{$userDetails->address}}" type="text" name="address" id="address" placeholder="Address"
								 required class="single-input">
							</div>
							<div class="mt-10">
								<input value="{{$userDetails->city}}" type="text" name="city" id="city" placeholder="City"
								 required class="single-input">
							</div>
							<div class="mt-10">
								<input value="{{$userDetails->state}}" type="text" name="state" id="state" placeholder="State"
								 required class="single-input">
							</div>
							<div class="input-group-icon mt-10">
								<div class="icon">
									<i class="fa fa-plane" aria-hidden="true"></i>
								</div>
								<div class="form-select" id="default-select">
									<select id="country" name="country">
										<option value="">{{ $userDetails->country }}</option>
										@foreach($countries as $country)
											<option value="{{ $country->country_name }}" @if($country->country_name == $userDetails->country_name) selected @endif>{{ $country->country_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="input-group-icon mt-10">
								<input value="{{$userDetails->pincode}}" type="text" name="pincode" id="pincode" placeholder="Address"
								 required class="single-input">
							</div>
							<div class="mt-10">
								<input value="{{$userDetails->mobile}}" type="text" name="mobile" placeholder="Mobile"class="single-input-primary">
							</div>
							<div class="input-group-icon mt-10">
								<button type="submit" value="submit" class="btn submit_btn">Update</button>
							</div>
						</form>
					</div>
					<div class="col-lg-6">
						<h3 class="mb-30 title_color">Password</h3>
						<form id="passwordForm" name="passwordForm" action="{{ url('/update-user-pwd')}}" method="POST"> {{ csrf_field() }}
							<div class="mt-10">
								<input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password"
								 required class="single-input">
								 <span id="chkPwd"></span>
							</div>
							<div class="mt-10">
								<input type="password" name="new_pwd" id="new_pwd" placeholder="New Password"
								 required class="single-input" required minlength="8">
							</div>
							<div class="mt-10">
								<input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password"
								 required class="single-input" required minlength="8">
							</div>
							<div class="input-group-icon mt-10">
								<button type="submit" value="submit" class="btn submit_btn">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Align Area -->

	<script type="text/javascript">
		
		$().ready(function(){
    // Validate Register form on keyup and subm
    $("#passwordForm").validate({
        rules:{
            current_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },
            new_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },
            confirm_pwd:{
                required:true,
                minlength:6,
                maxlength:20,
                equalTo:"#new_pwd"
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    Validate Register form on keyup and submit
    $("#accountForm").validate({
        rules:{
            name:{
                required:true,
                minlength:2,
                accept: "[a-zA-Z]+"
            },
            address:{
                required:true,
                minlength:6
            },
            city:{
                required:true,
                minlength:2
            },
            state:{
                required:true,
                minlength:2
            },
            country:{
                required:true
            }
        },
        messages:{
            name:{ 
                required:"Please enter your Name",
                minlength: "Your Name must be atleast 2 characters long",
                accept: "Your Name must contain letters only"       
            }, 
            address:{
                required:"Please provide your Address",
                minlength: "Your Address must be atleast 10 characters long"
            },
            city:{
                required:"Please provide your City",
                minlength: "Your City must be atleast 2 characters long"
            },
            state:{
                required:"Please provide your State",
                minlength: "Your State must be atleast 2 characters long"
            },
            country:{
                required:"Please select your Country"
            },
        }
    });

    $("#current_pwd").keyup(function(){
        var current_pwd = $(this).val();
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url:'/check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                /*alert(resp);*/
                if(resp=="false"){
                    $("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
                }else if(resp=="true"){
                    $("#chkPwd").html("<font color='green'>Current Password is correct</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });
});
	</script>
@endsection 