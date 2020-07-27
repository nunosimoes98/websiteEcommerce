@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">CMS Pagina</a> <a href="#" class="current">Ver Paginas</a> </div>
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
            <h5>Ver Páginas</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Titulo</th>
                  <th>URL</th>
                  <th>Estado</th>
                  <th>Criado</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($cmsPages as $page)
                <tr class="gradeX">
                  <td class="center">{{ $page->id }}</td>
                  <td class="center">{{ $page->title }}</td>
                  <td class="center">{{ $page->url }}</td>
                  <td class="center">@if($page->status==1) Active @else Inactive @endif</td>
                  <td class="center">{{ $page->created_at }}</td>
                  <td class="center">
                    <a href="#myModal{{ $page->id }}" data-toggle="modal" class="btn btn-success btn-mini">Ver</a> 
                    <a href="{{ url('/admin/edit-cms-page/'.$page->id) }}" class="btn btn-primary btn-mini">Editar</a> 
                    <a href="{{ url('/admin/delete-cms-page/'.$page->id) }}" class="btn btn-danger btn-mini">Apagar</a>
                        <div id="myModal{{ $page->id }}" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>{{ $page->title }} Detalhes</h3>
                          </div>
                          <div class="modal-body">
                            <p><strong>Titulo:</strong> {{ $page->title }}</p>
                            <p><strong>URL:</strong> {{ $page->url }}</p>
                            <p><strong>Estado:</strong> @if($page->status==1) Active @else Inactive @endif</p>
                            <p><strong>Criado em:</strong> {{ $page->created_at }}</p>
                            <p><strong>Descrição:</strong> {{ $page->description }}</p>
                          </div>
                        </div>

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