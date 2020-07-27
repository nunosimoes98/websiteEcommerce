@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>  <a href="#" class="current">Páginas</a> </div>

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
            <h5>Editar Página</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-cms-page/'.$cmsPage->id) }}" name="add_cms_page" id="add_cms_page" novalidate="novalidate">{{ csrf_field() }}
              <div class="control-group">
                <label class="control-label">Titulo</label>
                <div class="controls">
                  <input type="text" name="title" id="title" value="{{ $cmsPage->title }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">URL</label>
                <div class="controls">
                  <input type="text" name="url" id="url" value="{{ $cmsPage->url }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descrição</label>
                <div class="controls">
                  <textarea name="description">{{ $cmsPage->description }}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Disponível</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($cmsPage->status=="1") checked @endif value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Editar Página" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection