@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/admin/view-products">Products</a> <a href="#" class="current">Editar Produto</a> </div>
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
            <h5>Editar Produto</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-product/'.$productDetails->id) }}" name="edit_product" id="edit_product" novalidate="novalidate">{{ csrf_field() }}
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
                  <input type="text" name="product_name" id="product_name" value="{{ $productDetails->product_name }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Código</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code" value="{{ $productDetails->product_code }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Cor</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color" value="{{ $productDetails->product_color }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descrição</label>
                <div class="controls">
                  <textarea name="description">{{ $productDetails->description }}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Material</label>
                <div class="controls">
                  <textarea name="material">{{ $productDetails->material }}</textarea>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Preço (€) </label>
                <div class="controls">
                  <input type="text" name="price" id="price" value="{{ $productDetails->price }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Peso (g)</label>
                <div class="controls">
                  <input type="text" name="weight" id="weight" value="{{ $productDetails->weight }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Imagem</label>
                <div class="controls">
                  <div id="uniform-undefined">
                    <table>
                      <tr>
                        <td>
                          <input name="image" id="image" type="file">
                          @if(!empty($productDetails->image))
                            <input type="hidden" name="current_image" value="{{ $productDetails->image }}"> 
                          @endif
                        </td>
                        <td>
                          @if(!empty($productDetails->image))
                            <img style="width:30px;" src="{{ asset('/images/backend_images/products/small/'.$productDetails->image) }}"> | <a href="{{ url('/admin/delete-product-image/'.$productDetails->id) }}">Delete</a>
                          @endif
                        </td>
                      </tr>
                    </table>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Video</label>
                <div class="controls">
                  <div id="uniform-undefined">
                    <input name="video" id="video" type="file">
                    @if(!empty($productDetails->video))
                      <input type="hidden" name="current_video" value="{{ $productDetails->video }}">
                      <a target="_blank" href="{{ url('videos/'.$productDetails->video) }}">View</a> |
                      <a href="{{ url('/admin/delete-product-video/'.$productDetails->id) }}">Delete</a>
                    @endif
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Feature Item</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" @if($productDetails->feature_item == "1") checked @endif value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit Product" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection