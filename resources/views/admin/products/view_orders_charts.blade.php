<?php

$current_month = date('M');
$last_month = date('M',strtotime("-1 month"));
$last_to_last_month = date('M',strtotime("-2 month"));

?>

@extends('layouts.adminLayout.admin_design')
@section('content')

<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{

	},
	axisY: {
		title: "Número de encomendas"
	},
	data: [{        
		
		dataPoints: [      
			{ y: <?php echo $current_month_orders; ?>, label: "<?php echo $current_month; ?>" },
			{ y: <?php echo $last_month_orders; ?>,  label: "<?php echo $last_month; ?>" },
			{ y: <?php echo $last_to_last_month_orders; ?>,  label: "<?php echo $last_to_last_month; ?>" },

		]
	}]
});
chart.render();

}
</script>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/admin/dashboard" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/admin/view-orders">Encomendas</a> <a href="#" class="current">Ver Relatório Encomendas</a> </div>

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
            <h5>Relatório de Encomendas</h5>
          </div>
          <div class="widget-content nopadding">
           <div id="chartContainer" style="height: 370px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

@endsection
