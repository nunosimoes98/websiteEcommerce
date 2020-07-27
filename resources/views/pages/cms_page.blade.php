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


	<section class="sample-text-area">
		<div class="container">
			<div class="main_title">
                        <h2>{{ $cmsPageDetails->title }}</h2>
                    </div>
			<p class="sample-text">
				<?php echo nl2br($cmsPageDetails->description); ?>

			</p>
		</div>

	</section>
	

@endsection