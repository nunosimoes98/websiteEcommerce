@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Cupões</a> <a href="#" class="current">Ver Cupões</a> </div>

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
            <h5>Lista de Cupões</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID do cupão</th>
                  <th>Código do Cupão</th>
                  <th>Valor</th>
                  <th>Tipo</th>
                  <th>Validade</th>
                  <th>Data de criação</th>
                  <th>Estado</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($coupons as $coupon)
                <tr class="gradeX">
                  <td class="center">{{ $coupon->id }}</td>
                  <td class="center">{{ $coupon->coupon_code }}</td>
                  <td class="center">
                    {{ $coupon->amount }} 
                    @if($coupon->amount_type=="Percentage") % @else EUR @endif
                  </td>
                  <td class="center">{{ $coupon->amount_type }}</td>
                  <td class="center">{{ $coupon->expiry_date }}</td>
                  <td class="center">{{ $coupon->created_at }}</td>
                  <td class="center">
                    @if($coupon->status == 1) Ativo @else Inativo @endif
                  </td>
                  <td class="center">
                    <a href="{{ url('/admin/edit-coupon/'.$coupon->id) }}" class="btn btn-primary btn-mini" title="Edit Cupão">Editar</a> 
                    <a href="{{ url('/admin/delete-coupon/'.$coupon->id) }}" rel="{{ $coupon->id }}" rel1="delete_product" class="btn btn-danger btn-mini deleteRecord"  title="Delete Cupão">Apagar</a></td>
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