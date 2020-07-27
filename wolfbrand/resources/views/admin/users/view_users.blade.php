
@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Utilizadores</a> <a href="#" class="current">View utilizadores</a> </div>
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
            <h5>Utilizadores</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Utilizador ID</th>
                  <th>Nome</th>
                  <th>Morada</th>
                  <th>Cidade</th>
                  <th>Estado</th>
                  <th>País</th>
                  <th>Código-Postal</th>
                  <th>Telemóvel</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Registado</th>

                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr class="gradeX">
                  <td class="center">{{ $user->id }}</td>
                  <td class="center">{{ $user->name }}</td>
                  <td class="center">{{ $user->address }}</td>
                  <td class="center">{{ $user->city }}</td>
                  <td class="center">{{ $user->state }}</td>
                  <td class="center">{{ $user->country }}</td>
                  <td class="center">{{ $user->pincode }}</td>
                  <td class="center">{{ $user->mobile }}</td>
                  <td class="center">{{ $user->email }}</td>
                  <td class="center">
                    @if($user->status==1)
                      <span style="color:green">Ativo</span>
                    @else
                      <span style="color:red">Inativo</span>
                    @endif
                  </td>
                  <td class="center">{{ $user->created_at }}</td>
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
