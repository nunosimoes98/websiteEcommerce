
@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Subscritores</a> <a href="#" class="current">Ver subscritores</a> </div>
    <h1>Subscritores</h1>
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
  <div>
    <a href="{{ url('/admin/export-newsletter-emails')}}"></a>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Newsletters</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Utilizador ID</th>
                  <th>Email</th>
                  <th>Estado</th>
                  <th>Criado</th>
                  <th>Ações</th>



                </tr>
              </thead>
              <tbody>
                @foreach($newsletters as $newsletter)
                <tr class="gradeX">
                  <td class="center">{{ $newsletter->id }}</td>
                  <td class="center">{{ $newsletter->email }}</td>
                  <td class="center">
                    @if($newsletter->status==1)
                    <a href="{{ url('/admin/update-newsletter-status/'.$newsletter->id.'/0') }}">
                      <span style="color:green">Ativo</span></a>
                    @else
                    <a href="{{ url('/admin/update-newsletter-status/'.$newsletter->id.'/1') }}">
                      <span style="color:red">Inativo</span></a>
                    @endif
                  </td>
                  <td class="center">{{ $newsletter->created_at }}</td>
                  <td class="center"><a href="{{ url('/admin/delete-newsletter-email/'.$newsletter->id) }}"  class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
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
