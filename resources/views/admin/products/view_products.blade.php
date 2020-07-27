@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Produtos</a> <a href="#" class="current">Ver Produtos</a> </div>

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
            <h5>Lista de Produtos</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Produto ID</th>
                  <th>Categoria</th>
                  <th>Nome do Produto</th>
                  <th>Código do Produto</th>
                  <th>Cor do Produto</th>
                  <th>Preço</th>
                  <th>Imagem</th>
                  <th>Index</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($products as $product)
                <tr class="gradeX">
                  <td class="center">{{ $product->id }}</td>
                  <td class="center">{{ $product->category_name }}</td>
                  <td class="center">{{ $product->product_name }}</td>
                  <td class="center">{{ $product->product_code }}</td>
                  <td class="center">{{ $product->product_color }}</td>
                  <td class="center">{{ $product->price }}</td>
                  <td>
                    @if(!empty($product->image))
                    <img src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" style="width: 70px;">
                    @endif
                  </td>
                  <td class="center">@if($product->feature_item == 1) Yes @else No @endif</td>
                  <td class="center">
                    <a href="#myModal{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini" title="View Product">View</a> 
                    <a href="{{ url('/admin/edit-product/'.$product->id) }}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a> 
                    <a href="{{ url('/admin/add-attributes/'.$product->id) }}" class="btn btn-success btn-mini" title="Add Attributes">Add</a> 
                    <a href="{{ url('/admin/add-images/'.$product->id) }}" class="btn btn-info btn-mini">Img</a>
                    <a href="{{ url('/admin/delete-product/'.$product->id) }}" rel="{{ $product->id }}" rel1="delete_product" class="btn btn-danger btn-mini deleteRecord"  title="Delete Product">Delete</a></td>

                    <div id="myModal{{ $product->id }}" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3> Deatalhes Completos de {{ $product->product_name }}</h3>
                          </div>
                          <div class="modal-body">
                            <p>ID do Produto: {{ $product->id }}</p>
                            <p>ID da Categoria: {{ $product->category_id }}</p>
                            <p>Código: {{ $product->product_code }}</p>
                            <p>Cor do Produto: {{ $product->product_color }}</p>
                            <p>Preço: €{{ $product->price }}</p>
                            <p>Descrição: {{ $product->description }}</p>
                          </div>
                        </div>
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