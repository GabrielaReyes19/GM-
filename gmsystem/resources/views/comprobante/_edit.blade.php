<?php 
    $loadImg = "<img src=".URL::to('/')."/public/pixeladmin/images/plugins/bootstrap-editable/preloader.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus" style="font-size: 25px;"></i> 
        <span id="titulo" style="font-size: 28px;">
        @if($id2=="1")
            Editar Cotización
        @else
            Nueva Cotización
        @endif
        </span>
    </span>

</div>
<div class="modal-body">
    <!-- Default -->
    <form id="modal-{{ $nameModule }}-form">
        {{ csrf_field() }}
        @include('comprobante.formFactura',['cboTipo' => $id, 'btnText' => 'Actualizar'])
        @include('comprobante.jsFactura',['cboTipo' => $id, 'btnText' => 'Actualizar'])
    </form>
</div>
