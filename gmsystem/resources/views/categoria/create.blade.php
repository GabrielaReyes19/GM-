<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Nueva Categoria</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form id="modal-cat-{{ $nameModule }}-form">
		{{ csrf_field() }}
        @include('categoria.form', ['categoria' => new App\Categoria, 'cboTipo' => '1'])
        @include('categoria.javascripts', ['id' =>''])
	</form>
</div>

