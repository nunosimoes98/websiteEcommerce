<?php $url = url()->current(); ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    @if(Session::get('adminDetails')['categories_full_access']==1)
    
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categorias</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/category/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-category')}}">Adicionar Categorias</a></li>
        <li <?php if (preg_match("/view-categories/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-categories')}}">Ver Categorias</a></li>
      </ul>
    </li>
    @else
    <li <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categorias</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/category/i", $url)){ ?> style="display: block;" <?php } ?>>

        <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-category')}}">Adicionar Categorias</a></li>
        @if(Session::get('adminDetails')['categories_view_access']==1)
        <li <?php if (preg_match("/view-categories/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-categories')}}">Ver Categorias</a></li>
        @endif
      </ul>
    </li>
    @endif
     @if(Session::get('adminDetails')['admin_access']==1)
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Administradores</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/admin/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-admin/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-admin')}}">Adicionar Admin</a></li>
        <li <?php if (preg_match("/view-admins/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-admins')}}">Ver Administradores</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Cupões</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-coupon')}}">Adicionar Cupões</a></li>
        <li <?php if (preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-coupons')}}">Ver Cupões</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Subscritores</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/newsletter-subscribers/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/newsletter-subscribers/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-newsletter-subscribers')}}">Ver Subscritores</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Páginas</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/cms-page/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-cms-page/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-cms-page')}}">Adicionar Página</a></li>
        <li <?php if (preg_match("/view-cms-pages/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-cms-pages')}}">Ver Páginas</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Custos</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/shipping/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-shipping/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-shipping')}}">Custos de Envio</a></li>
      </ul>
    </li>
  
    @endif
    @if(Session::get('adminDetails')['products_access']==1)
     <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Produtos</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/product/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-product')}}">Adicionar Produtos</a></li>
        <li <?php if (preg_match("/view-products/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-products')}}">Ver Produtos</a></li>
      </ul>
    </li>
    @endif
    
    <?php $base_user_url = trim(basename($url));
    ?>
    @if(Session::get('adminDetails')['users_access']==1)
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Utilizadores</span> <span class="label label-important">3</span></a>
      <ul <?php if (preg_match("/users/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if ($base_user_url=="/view-users"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users')}}">Ver Utilizadores</a></li>
        <li <?php if ($base_user_url=="/view-users-charts"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users-charts')}}">Ver Relatório</a></li>
      </ul>
    </li>
    @endif
    <?php $base_user_url = trim(basename($url));
    ?>
    @if(Session::get('adminDetails')['orders_access']==1)
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Encomendas</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/orders/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if ($base_user_url=="/view-orders"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-orders')}}">Ver Encomendas</a></li>
        <li <?php if ($base_user_url=="/view-orders-charts"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-orders-charts')}}">Ver Relatório</a></li>
      </ul>
    </li>
    @endif
    
    
  </ul>
</div>
<!--sidebar-menu-->