@extends('layouts.adminLayout.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Encomendas</a> </div>
    <h1>Encomenda #{{ $orderDetails->id }}</h1>
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
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">

          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc">Data</td>
                  <td class="taskStatus">{{ $orderDetails->created_at }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Estado</td>
                  <td class="taskStatus">{{ $orderDetails->order_status }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Total</td>
                  <td class="taskStatus">{{ $orderDetails->grand_total }}€</td>
                </tr>
                <tr>
                  <td class="taskDesc">Custos Transporte</td>
                  <td class="taskStatus">{{ $orderDetails->shipping_charges }}€</td>
                </tr>
                <tr>
                  <td class="taskDesc">Código do Cupão</td>
                  <td class="taskStatus">{{ $orderDetails->coupon_code }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Desconto</td>
                  <td class="taskStatus">{{ $orderDetails->coupon_amount }}€</td>
                </tr>
                <tr>
                  <td class="taskDesc">Método de Pagamento</td>
                  <td class="taskStatus">{{ $orderDetails->payment_method }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">
            <h5>Detalhes Utilizador</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc">Nome</td>
                  <td class="taskStatus">{{ $orderDetails->name }}</td>
                </tr>
                <tr>
                  <td class="taskDesc">Email</td>
                  <td class="taskStatus">{{ $orderDetails->user_email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> 
                <h5>Atualizar estado da Encomenda</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content"> 
                <form action="{{ url('admin/update-order-status') }}" method="post">{{ csrf_field() }}
                  <input type="hidden" name="order_id" value="{{ $orderDetails->id }}">
                  <table width="100%">
                    <tr>
                      <td>
                        <select name="order_status" id="order_status" class="control-label" required="">
                          <option value="New" @if($orderDetails->order_status == "New") selected @endif>Novo</option>
                          <option value="Pending" @if($orderDetails->order_status == "Pending") selected @endif>Pendente</option>
                          <option value="Cancelled" @if($orderDetails->order_status == "Cancelled") selected @endif>Cancelado</option>
                          <option value="In Process" @if($orderDetails->order_status == "In Process") selected @endif>Em processo</option>
                          <option value="Shipped" @if($orderDetails->order_status == "Shipped") selected @endif>Enviado</option>
                          <option value="Delivered" @if($orderDetails->order_status == "Delivered") selected @endif>Entregue</option>
                          <option value="Paid" @if($orderDetails->order_status == "Paid") selected @endif>Pago</option>
                        </select>
                      </td>
                      <td>
                        <input type="submit" value="Atualizar">
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
       	<div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> 
                <h5>Morada de Entrega</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content"> 
                {{ $orderDetails->name }} <br>
                {{ $orderDetails->address }} <br>
                {{ $orderDetails->city }} <br>
                {{ $orderDetails->state }} <br>
                {{ $orderDetails->country }} <br>
                {{ $orderDetails->pincode }} <br>
                {{ $orderDetails->mobile }} <br></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
              <tr>
                  <th>Código do Produto</th>
                  <th>Nome</th>
                  <th>Tamanho</th>
                  <th>Cor</th>
                  <th>Preço</th>
                  <th>Quantidade</th>
              </tr>
          </thead>
          <tbody>
            @foreach($orderDetails->orders as $pro)
              <tr>
                  <td>{{ $pro->product_code }}</td>
                  <td>{{ $pro->product_name }}</td>
                  <td>{{ $pro->product_size }}</td>
                  <td>{{ $pro->product_color }}</td>
                  <td>{{ $pro->product_price }}</td>
                  <td>{{ $pro->product_qty }}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
    </div>
  </div>
</div>
<!--main-container-part-->

@endsection