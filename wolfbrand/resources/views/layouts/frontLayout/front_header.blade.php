<?php 
use App\Http\Controllers\Controller;
use App\Product;
$mainCategories =  Controller::mainCategories();
$cartCount = Product::cartCount();
?>

<style type="text/css">
.loader {
    position: fixed;
    z-index: 99;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader > img {
    width: 100px;
}

.loader.hidden {
    animation: fadeOut 0.4s;
    animation-fill-mode: forwards;
}

@keyframes fadeOut {
    100% {
        opacity: 0;
        visibility: hidden;
    }
}

.thumb {
    height: 100px;
    border: 1px solid black;
    margin: 10px;
}
</style>

<script type="text/javascript">
	window.addEventListener("load", function () {
    const loader = document.querySelector(".loader");
    loader.className += " hidden"; // class "loader hidden"
});
</script>
<!-- Preloader Start -->
    <div class="loader">
    <img src="{{ asset('images/frontend_images/logo.png') }}" alt="Loading..." />
	</div>
    <!-- Preloader Start -->
<header class="header_area">
		<div class="top_menu row m0">
			<div class="container-fluid">
				<div class="float-left">
					<p>Mail: wolfworkbrand@gmail.com</p>
				</div>
				<div class="float-right">
					<ul class="right_side">
						@if(!empty(Auth::check()))
						<li>
							<a href="{{url('/orders') }}">
								My Orders
							</a>
						</li>
						<li>
							<a href="{{url('/user-logout') }}">
								Logout
							</a>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="{{ url('./') }}">
						<img src="{{ asset('images/frontend_images/logo-w.png') }}" alt="" >
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					 aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<div class="row w-100">

							<div class="col-lg-7 pr-0">
								<ul class="nav navbar-nav center_nav pull-right">
									<li class="nav-item">
										<a class="nav-link" href="/">Home</a>
									</li>
									<li class="nav-item submenu dropdown">
										<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
										<ul class="dropdown-menu">
											<li class="nav-item">
												<a class="nav-link" href="{{ asset('/allproducts') }}">All Products</a>
											</li>
											@foreach($mainCategories as $cat)
											<li class="nav-item">
												<a class="nav-link" href="{{ asset('products/'.$cat->url) }}">{{ $cat->name }}</a>
											</li>
											@endforeach

										</ul>
									</li>

									<li class="nav-item">
										<a class="nav-link" href="{{url('/pages/post')}}">Contact</a>
									</li>

									<li class="nav-item submenu dropdown">
										<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>
										<ul class="dropdown-menu">
											<li class="nav-item">
												<a class="nav-link" href="{{url('page/about-us')}}">About Us</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ url('page/terms-conditions') }}">Terms & Conditions </a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ url('page/privacy-policy') }}">Privacy Policy</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{{ url('page/refund-policy') }}">Refund Policy</a>
											</li>
											
										</ul>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="{{url('/instagram-wolf')}}">Instagram</a>
									</li>
								</ul>
								<ul></ul>
							</div>



							<div class="col-lg-5">
								<ul class="nav navbar-nav navbar-right right_nav pull-right">

									@if(!empty(Auth::check()))
									<li class="nav-item">
										<a href="{{url('/user-account') }}" class="icons">
											<i class="fa fa-user" aria-hidden="true"></i>
										</a>
									</li>
									
									<hr>

									<li class="nav-item">
										<a href="{{url('/wish-list') }}" class="icons">
											<i class="fa fa-heart-o" aria-hidden="true"></i>
										</a>
									</li>

									<hr>

									<li class="nav-item">
										<a href="{{ url('/cart')}}" class="icons">
											<i class="lnr lnr lnr-cart"></i>
										</a>
									</li>
									@else
									<li class="nav-item">
										<a class="nav-link" href="{{url('/user-register')}}">Sign In / Register  </a>
									</li>

									@endif
								
								</ul>
							</div>
						</div>

					</div>
					<form class="form-inline ml-auto" action="{{ url('/search-products') }}" method="post">{{ csrf_field() }}
		                <input type="text" name="product" class="form-control mr-sm-2" placeholder="Search" >
		                <button type="submit" class="btn btn-outline-light">Search</button>
		            </form>
				</div>
			</nav>
		</div>
	</header>