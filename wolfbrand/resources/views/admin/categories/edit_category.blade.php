@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/admin/view-categories">Categorias de Produtos</a> <a href="#" class="current">Editar Categoria </a> </div>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Category</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-category/'.$categoryDetails->id) }}" name="edit_category" id="edit_category" novalidate="novalidate"> {{ csrf_field() }}
              <div class="control-group">
                <label class="control-label">Nome da Categoria</label>
                <div class="controls">
                  <input type="text" name="category_name" id="{{ $categoryDetails->name }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descrição</label>
                <div class="controls">
                   <textarea name="description">{{ $categoryDetails->description }}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                  <input type="text" name="url" id="url" value="{{ $categoryDetails->url }}">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Editar Categoria" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection