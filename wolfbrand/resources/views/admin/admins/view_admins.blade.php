@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admins/SubAdmins</a> <a href="#" class="current">Ver Admins/SubAdmins</a> </div>
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
            <h5>Admins/SubAdmins</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="text-align: center;">ID</th>
                  <th style="text-align: center;">Nome</th>
                  <th style="text-align: center;">Tipo</th>
                  <th style="text-align: center;">Permissões</th>
                  <th style="text-align: center;">Estado</th>
                  <th style="text-align: center;">Criado</th>
                  <th style="text-align: center;">Atualizado</th>
                  <th style="text-align: center;">Ações</th>


                </tr>
              </thead>
              <tbody>
                @foreach($admins as $admin)
                <?php 
                  $roles = "";
                  if($admin->categories_access == 1){
                    $roles .= "Categorias, ";
                  }
                  if($admin->products_access == 1){
                    $roles .= "Produtos, ";
                  }
                  if($admin->orders_access == 1){
                    $roles .= "Encomendas, ";
                  }
                  if($admin->users_access == 1){
                    $roles .= "Utilizadores, ";
                  }
                  if(($admin->categories_access == 1) && ($admin->products_access == 1) && ($admin->orders_access == 1) && ($admin->users_access == 1)){
                    $roles = "Todas";
                  }
              
                ?>
                <tr class="gradeX">
                  <td class="center">{{ $admin->id }}</td>
                  <td class="center">{{ $admin->username }}</td>
                  <td class="center">{{ $admin->type }}</td>
                  <td class="center">{{ $roles }}</td>
                  <td class="center">
                    @if($admin->status==1)
                      <span style="color:green">Ativo</span>
                    @else
                      <span style="color:red">Inativo</span>
                    @endif
                  </td>
                  <td class="center">{{ $admin->created_at }}</td>
                  <td class="center">{{ $admin->updated_at }}</td>
                  <td class="center">
                    <a href="{{ url('/admin/edit-admin/'.$admin->id) }}" class="btn btn-primary btn-mini">Editar</a> 
                   
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
