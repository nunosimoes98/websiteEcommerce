@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Encomendas</a> <a href="#" class="current">Ver Encomendas</a> </div>

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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Encomendas</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID da encomenda</th>
                  <th>Data</th>
                  <th>Nome do Cliente</th>
                  <th>Email do Cliente</th>
                  <th>Produtos</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Método de Pagamento</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($orders as $order)
                <tr class="gradeX">
                  <td class="center">{{ $order->id }}</td>
                  <td class="center">{{ $order->created_at }}</td>
                  <td class="center">{{ $order->name }}</td>
                  <td class="center">{{ $order->user_email }}</td>
                  <td class="center">
                    @foreach($order->orders as $pro)
                    {{ $pro->product_code }}
                    ({{ $pro->product_qty }})
                    <br>
                    @endforeach
                  </td>
                  <td class="center">{{ $order->grand_total }}€</td>
                  <td class="center">{{ $order->order_status }}</td>
                  <td class="center">{{ $order->payment_method }}</td>
                  <td class="center">
                    <a target="_blank" href="{{ url('admin/view-order/'.$order->id)}}" class="btn btn-success btn-mini">Ver Detalhes</a> 
                    @if($order->order_status == "Shipped" || $order->order_status == "Delivered" || $order->order_status == "Paid")
                    <a target="_blank" href="{{ url('admin/view-order-invoice/'.$order->id)}}" class="btn btn-warning btn-mini">Ver Fatura</a> 
                    <a target="_blank" href="{{ url('admin/view-pdf-invoice/'.$order->id)}}" class="btn btn-prima btn-mini">PDF</a> 
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
