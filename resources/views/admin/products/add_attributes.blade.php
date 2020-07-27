@extends('layouts.adminLayout.admin_design')
@section('content')
<section>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/admin/view-products">Produtos</a> <a href="#" class="current">Adicionar atributos ao produto</a> </div>
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
            <h5>Adicionar atributos ao Produto</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-attributes/'.$productDetails->id) }}" name="add_attribute" id="add_attribute" novalidate="novalidate"> {{ csrf_field() }}
              <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
              <div class="control-group">
                <label class="control-label">Category Name</label>
                <label class="control-label">{{ $category_name }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Nome do Produto</label>
                <label class="control-label">{{ $productDetails->product_name }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Código do Produto</label>
                <label class="control-label">{{ $productDetails->product_code }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Cor do Produto</label>
                <label class="control-label">{{ $productDetails->product_color }}</label>
              </div>
              <div class="control-group">
                <label class="control-label"></label>
                 <div class="field_wrapper">
                   <div>
                    <input required type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;">
                    <input required type="text" name="size[]" id="size" placeholder="Size" style="width:120px;">
                    <input required type="text" name="price[]" id="price" placeholder="Price" style="width:120px;"> 
                    <input required type="text" name="stock[]" id="stock" placeholder="Stock" style="width:120px;">
                   </div>
                </div>
              </div>
            </div>
              <div class="form-actions">
                <input type="submit" value="Inserir" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Lista de Atributos</h5>
          </div>
          <div class="widget-content nopadding">
            <form action="{{ url('/admin/edit-attributes/'.$productDetails->id) }}" method="post">
              {{ csrf_field() }}
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID do Atributo</th>
                  <th>Referência</th>
                  <th>Tamanho</th>
                  <th>Preço</th>
                  <th>Stock</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($productDetails->attributes as $attribute)
                  <tr class="gradeX">
                    <td class="center"><input type="hidden" name="idAttr[]" value="{{ $attribute->id }}">{{ $attribute->id }}</td>
                    <td class="center">{{ $attribute->sku }}</td>
                    <td class="center">{{ $attribute->size }}</td>
                    <td class="center"><input name="price[]" type="text" value="{{ $attribute->price }}" /></td>
                    <td class="center"><input name="stock[]" type="text" value="{{ $attribute->stock }}" required /></td> 
                    <td class="center">
                      <input type="submit" value="Update" class="btn btn-primary btn-mini" />
                      <a href="{{ url('admin/delete-attribute/'.$attribute->id) }}" class="btn btn-danger btn-mini">Apagar</a>
                    </td>

                  </tr>
                  @endforeach
              </tbody>
            </table>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</section>
@endsection