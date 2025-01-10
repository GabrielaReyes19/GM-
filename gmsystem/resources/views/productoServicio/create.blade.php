<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Nuevo Producto</span></span>
</div>
<div class="modal-body">
	<!-- Default -->
	<form  enctype="multipart/form-data" id="modal-{{ $nameModule }}-form">
		{{ csrf_field() }}
        @include('productoServicio.form', ['producto' => new App\ProductoServicio, 'cboTipo' => '1'])
        @include('productoServicio.javascripts', ['producto' => new App\ProductoServicio, 'id' =>''])
	</form>
</div>

