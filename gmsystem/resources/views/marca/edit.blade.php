<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Actualizar Clasificación: {{$marca->c_nom}}</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form id="modal-mar-{{ $nameModule }}-form">
		{!! method_field('PUT') !!}
        @include('marca.form', ['cboTipo' => '2'])
        @include('marca.javascripts',['btnText' => 'Actualizar', 'id' => $marca->pk_mar_id])
	</form>
</div>

