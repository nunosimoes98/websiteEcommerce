@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Custos</a> <a href="#" class="current">Custos Envio</a> </div>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
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
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Editar Custos</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-shipping/'.$shippingDetails->id) }}" name="edit_shipping" id="edit_shipping" novalidate="novalidate">{{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $shippingDetails->id }}">
              <div class="control-group">
                <label class="control-label">País</label>
                <div class="controls">
                  <input readonly="" type="text" value="{{ $shippingDetails->country }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="font-size: 13px; width: 200px;">Custo (0-500g)&nbsp;</label>
                <div class="controls">
                  <input type="text" name="shipping_charges0_500g" id="shipping_charges0_500g"  value="{{ $shippingDetails->shipping_charges0_500g }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="font-size: 13px; width: 200px;">Custo (501g-1000g)&nbsp;</label>
                <div class="controls">
                  <input type="text" name="shipping_charges501_1000g" id="shipping_charges501_1000g"  value="{{ $shippingDetails->shipping_charges501_1000g }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="font-size: 13px; width: 200px;">Custo (1001g-2000g)&nbsp;</label>
                <div class="controls">
                  <input type="text" name="shipping_charges1001_2000g" id="shipping_charges1001_2000g"  value="{{ $shippingDetails->shipping_charges1001_2000g }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="font-size: 13px; width: 200px;">Custo (2001g-5000g)&nbsp;</label>
                <div class="controls">
                  <input type="text" name="shipping_charges2001_5000g" id="shipping_charges2001_5000g"  value="{{ $shippingDetails->shipping_charges2001_5000g }}">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Editar Custos" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection