<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Nueva Clasificación</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form id="modal-cla-{{ $nameModule }}-form">
		{{ csrf_field() }}
        @include('clasificacion.form', ['clasificacion' => new App\Clasificacion, 'cboTipo' => '1'])
        @include('clasificacion.javascripts', ['id' =>'' ])
	</form>
</div>

