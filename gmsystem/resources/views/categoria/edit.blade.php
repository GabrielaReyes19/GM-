<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Actualizar Categoria: {{$categoria->c_nom}}</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form id="modal-cat-{{ $nameModule }}-form">
		{!! method_field('PUT') !!}
        @include('categoria.form', ['cboTipo' => '2'])
        @include('categoria.javascripts',['btnText' => 'Actualizar', 'id' => $categoria->pk_cat_id])
	</form>
</div>

