<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Actualizar Clasificación: {{$clasificacion->c_nom}}</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form id="modal-cla-{{ $nameModule }}-form">
		{!! method_field('PUT') !!}
        @include('clasificacion.form', ['cboTipo' => '2'])
        @include('clasificacion.javascripts',['btnText' => 'Actualizar', 'id' => $clasificacion->pk_cla_id])
	</form>
</div>

