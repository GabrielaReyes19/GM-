@extends('layout')

@section('contend')
<?php 
    $loadImg = "<img src=".URL::to('/')."/public/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
<div class="page-header padding-xs-vr" style="margin: -18px -18px 5px -18px;">      
    <div class="row">

        <h1 class="col-xs-12 col-sm-6 text-center text-left-sm">
            <i class="fa fa-group page-header-icon text-primary"></i>&nbsp;
            CLIENTES / Administrador
        </h1>
        <div class="col-xs-12 col-sm-6">
            <div class="row">
                <hr class="visible-xs no-grid-gutter-h">        
                {{-- {!! $loadImgDt !!}  --}}                                  
                <div class="pull-right col-xs-12 col-sm-auto">
                <a href="#" class="btn btn-primary btn-labeled" id="{{ $btnCreate }}" style="width: 100%;">
                    <span class="btn-label icon fa fa-plus"></span>Nuevo
                </a>
                </div>
                <!-- Margin -->
                <div class="visible-xs clearfix form-group-margin"></div>

            </div>
        </div>
    
    </div>
    
</div>
<input type="hidden" name="doc" id="doc" class="form-control input-sm" autocomplete="off" autofocus="" />

<!-- <div class="row">
    <div class="col-md-12">
        <div class="panel panel-info" style="margin-bottom: 0px;">
            <div class="panel-heading padding-xs-hr no-padding-vr">
                    <span class="panel-title">Busqueda</span>
            </div>
            <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
                <div class="row" style="padding-bottom:0px">
                    <div class="col-md-2">
                        <label class="control-label no-margin-b">N° Doc</label>
                        <input type="text" name="doc" id="doc" class="form-control input-sm" autocomplete="off" autofocus="" />
                    </div>
                    <div class="col-md-1">
                        <label class="control-label no-margin-b"> &nbsp; </label>
                        <button type="button" class="btn btn-success btn-block" id="loadData">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   -->

<div class="table-light table-responsive">
    {{-- <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example"> --}}
    <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer " id="jq-datatables-{{ $nameModule }}" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;">Tipo</th>
                <th style="text-align: center;">NÚMERO</th>
                <th style="text-align: center;">DENOMINACIÓN / NOMBRES</th>
                <th style="text-align: center;">DIRECCIÓN FISCAL</th>
                <th style="text-align: center;">EMAILS</th> 
                <th style="text-align: center;">TELÉFONOS</th> 
                <th style="text-align: center;">ESTADO</th> 
                <th></th> 
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<hr class="no-grid-gutter-h">


<div id="modal-{{ $nameModule }}" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content-modal-{{ $nameModule }}">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->
<div id="modal-{{ $nameModule }}-sm" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="content-modal-{{ $nameModule }}-sm">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<script>
init.push(function () {        

   
});

var oTableOptions = {
    "order": [[ 0, "ASC" ]],
    //"lengthMenu": [ [10, 20, 50], [10, 20, 50] ],
    "lengthMenu": [ [10, 15, 20, -1], [10, 15, 20, "Todos"] ],
    "pageLength": 10,
    "processing": true,
    "serverSide": true,
    "pagingType": "full_numbers",
    "stateSave": false,
    
    "ajax":{
    "url": "{{ url('api') }}.{{ $nameModule }}",
    "data": function ( d ) {
        return $.extend( {}, d, {
            "_token": "{{ csrf_token() }}"
        });
    }, 
    "type": "POST",
        /*"data": function ( d ) {
            d.extra_search = $('#extra').val();
        }*/
    },

    "columnDefs": 
    [
        {"targets": 0, 'data': 'c_abr', 'name':'c_abr', 'orderable': false},
        {"targets": 1, 'data': 'c_num_doc', 'name':'c_num_doc'},
        {"targets": 2, 'data': 'c_raz', 'name':'c_raz'},
        {"targets": 3, 'data': 'c_dir', 'name':'c_dir'},
        {"targets": 4, 'data': 'c_cor', 'name':'c_cor'},
        {"targets": 5, 'data': 'c_tel', 'name':'c_tel', 'orderable': false},
        {"targets": 6, 'data': 'estado', 'name':'estado', 'orderable': false},
        {"targets": 7, 'data': 'action', 'name': 'action', 'orderable': false, 'searchable': false}
        
    ],
                                        
    "language":
    {
        "processing": "Refrescando data...",
        //"search":     "",
        "lengthMenu": "items x pág. _MENU_",
        "zeroRecords": "No se encontraron registros.",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "No hay registros.",
        "infoFiltered": "(filtered from _MAX_ total entries)",
        "paginate": {
            "first": "<<",
            "previous": "<",
            "next": ">",
            "last" : ">>"
        }
     },
    "sDom": '<"table-header padding-xs-vr no-margin-hr clearfix" <"table-caption"> <"clear"T> <"DT-lf-right" <"DT-per-page"l> <"DT-search"f> > > t <"table-footer padding-xs-hr clearfix" <"DT-label"i> <"DT-pagination"p> >',   
};

var oTable = $('#jq-datatables-{{ $nameModule }}').DataTable(
    oTableOptions
);


$('#{{ $btnCreate }}').click(function() {
    var data = "";

    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Creando...');                 
            $('#{{ $btnCreate }}').attr({
                'class': "btn btn-primary btn-labeled disabled",
            });                                     
        },
        type: "GET",
        cache: false,
        url: "{{ url('cliente/create') }}",
        data: data,
        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}').html(response);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Nuevo');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                });     
            }else{
                alert("No se cre&oacute; cliente "+response.error);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Nuevo');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                }); 
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}").html('');
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Nuevo');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                });
                
                $('#modal-{{ $nameModule }}').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false;
});

function renderUpdate(id, id2){
    
    $('#modal-{{ $nameModule }}').modal({
        show:true,
    });
    
    $.ajax({
        beforeSend: function(){
          $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");
        },
        type: 'GET',
        cache: false,
        url: "{{ url('/cliente') }}/"+id+"/edit",
        {{-- data: data, --}}
        success:function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}').html(response);
                $.growl({ title: "OK:", message: "Se carg&oacute; cliente<br/>NÚMERO: " + id2, size: 'large' }); 
            }else{
                alert("No se cre&oacute; cliente"+response.error);
            }
        },
        error: function(e){
             $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#modal-{{ $nameModule }}").html('');                           
                $('#modal-{{ $nameModule }}').modal('hide');
            }, 4000);   
        },
        dataType:'html'
    });
}

function deleteCliente(id,id2){
    bootbox.confirm({
    title: "Seguro de eliminar cliente?",
    message: " ",
    buttons: {
        confirm: {
            label: 'OK',
            className: 'btn btn-success'
        },
        cancel: {
            label: 'Cancelar',
            className: 'btn '
        }
    },
    callback: function(result) {
        if(result){ 
            eliminarCliente(id,id2);
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarCliente(id,id2){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "{{ url('/cliente') }}/"+id,
        //data : data,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                $.growl.notice({
                    title: "Mensaje:",
                    message: "Se elimin&oacute; cliente:<br />NÚMERO: "+id2,
                    size: 'large'
                });
                 
            }else{
                $.growl.warning({
                    title: "Mensaje:",
                    message: "No se puede eliminar el registro porque tiene relacion con otras tablas",
                    size: 'large'
                });
            }
            $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();   
        },
        error : function(data) {
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar cliente!" , size: 'large' });     
        },

        dataType : 'json'
    });
}
</script>
@stop