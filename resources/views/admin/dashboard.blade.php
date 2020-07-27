@extends('layouts.adminLayout.admin_design')
@section('content')
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">

        <li class="bg_lb"> <a href="{{ url('admin/dashboard') }}"> <i class="icon-dashboard"></i> <span class="label label-important">20</span> My Dashboard </a> </li>

        @if(Session::get('adminDetails')['categories_view_access']==1)
        <li class="bg_lg span3"> <a href="{{ url('admin/view-categories') }}"> <i class="icon-signal"></i> Categories </a> </li>
        @endif
        @if(Session::get('adminDetails')['products_access']==1)
        <li class="bg_ly"> <a href="{{ url('admin/view-products') }}"> <i class="icon-inbox"></i><span class="label label-success">101</span> Products </a> </li>
        @endif
        @if(Session::get('adminDetails')['orders_access']==1)
        <li class="bg_lo"> <a href="{{ url('admin/view-orders') }}"> <i class="icon-th"></i> Orders</a> </li>
        @endif
        @if(Session::get('adminDetails')['users_access']==1)
        <li class="bg_ls"> <a href="{{ url('admin/view-users') }}"> <i class="icon-fullscreen"></i> Users</a> </li>
        @endif


      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      
    </div>
<!--End-Chart-box--> 
    <hr/>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
            <h5>Latest Posts</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{asset('images/backend_images/demo/av1.jpg')}}"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{asset('images/backend_images/demo/av2.jpg')}}"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{asset('images/backend_images/demo/av4.jpg')}}"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a> </p>
                </div>
              <li>
                <button class="btn btn-warning btn-mini">View All</button>
              </li>
            </ul>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<!--end-main-container-part-->

@endsection