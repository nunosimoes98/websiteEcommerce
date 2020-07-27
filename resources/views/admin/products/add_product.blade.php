@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/admin/view-products">Produtos</a> <a href="#" class="current">Adicionar Produto</a> </div>
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
            <h5>Adicionar Produto</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-product') }}" name="add_product" id="add_product" novalidate="novalidate"> {{ csrf_field() }}
              
              <div class="control-group">
                <label class="control-label">Categoria</label>
                <div class="controls">
                  <select name="category_id" id="category_id" style="width:220px;">
                    <?php echo $categories_dropdown; ?>
                    
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Nome do Produto</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Codigo do Produto</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Cor do Produto</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descrição</label>
                <div class="controls">
                  <textarea id="froala-editor" name="description" id="description" class="textarea_editor"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Material</label>
                <div class="controls">
                  <textarea name="material" id="material"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Preço (€)</label>
                <div class="controls">
                  <input type="text" name="price" id="price">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Peso (g)</label>
                <div class="controls">
                  <input type="text" name="price" id="price">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Imagem</label>
                <div class="controls">
                  <div id="uniform-undefined"><input name="image" id="image" type="file"></div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Video</label>
                <div class="controls">
                  <div id="uniform-undefined"><input name="video" id="video" type="file"></div>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Página Inicial</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" value="1" />
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Adicionar Produto" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection