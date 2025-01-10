@extends('layout')

@section('contend')
<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/preloader.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/blackboard.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.min.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.min.js"></script>
<div class="page-header padding-xs-vr" style="margin: -18px -18px 5px -18px;">      
    <div class="row">

        <h1 class="col-xs-12 col-sm-6 text-center text-left-sm">
            <i class="fa fa-shopping-cart page-header-icon text-primary"></i>&nbsp;
            PRODUCTOS Y SERVICIOS / Administrador
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

<form action="" id="find-{{ $nameModule }}-form" accept-charset="UTF-8" novalidate="novalidate">
   {{--  <div class="row">
        <div class="col-md-12">
        <div class="panel panel-info" style="margin-bottom: 0px;">
                <div class="panel-heading padding-xs-hr no-padding-vr">
                    <span class="panel-title">Busqueda</span>
                </div>
                <div class="panel-body padding-xs-vr padding-xs-hr text-xs " style="padding-bottom: 0px!important;">
                    <div class="row" style="padding-bottom:0px">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    Clasificaci&oacute;n:  
                                    <a href="#" onclick="clasificacionModal();" title="Nuevo" id="btn_cla_{{ $nameModule }}" class="btn btn-xs btn-outline btn-primary add-tooltip"><i class="fa fa-plus"></i></a>
                                    <a href="#" onclick="renderUpdateClasificacion();" id="btn_upd_cla_{{ $nameModule }}" title="Actualizar" class="btn btn-xs btn-outline btn-success add-tooltip"><i class="fa fa-pencil-square-o"></i></a>
                                    <a href="#" onclick="deleteClasificacion();" title="Eliminar" class="btn btn-xs btn-outline btn-danger add-tooltip"><i class="fa fa-times"></i></a>    
                                </label>
                                <select id="clasificacionId2" name="clasificacionId2" class="form-control" onchange="cboCategoria($(this).val(),'1')">
                                </select>
                            </div>    
                        </div>
                         
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label class="control-label" >
                                    Categoria:
                                    <a href="#" onclick="categoriaModal();" title="Nuevo" id="btn_cat_{{ $nameModule }}" class="btn btn-xs btn-outline btn-primary add-tooltip"><i class="fa fa-plus"></i></a>
                                    <a href="#" onclick="renderUpdateCategoria();" id="btn_upd_cat_{{ $nameModule }}" title="Actualizar" class="btn btn-xs btn-outline btn-success add-tooltip"><i class="fa fa-pencil-square-o"></i></a>
                                    <a href="#" onclick="deleteCategoria();" title="Eliminar" class="btn btn-xs btn-outline btn-danger add-tooltip"><i class="fa fa-times"></i></a>           
                                </label>
                                <div id="cargaCategoriaIndex">
                                    <select id="categoriaId" name="categoriaId" class="form-control" >
                                        <option value="">[TODOS]</option> 
                                    </select>
                                </div>          
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label class="control-label" >
                                    Marca:
                                    <a href="#" onclick="marcaModal();" title="Nuevo" id="btn_mar_{{ $nameModule }}" class="btn btn-xs btn-outline btn-primary add-tooltip"><i class="fa fa-plus"></i></a>
                                    <a href="#" onclick="renderUpdateMarca();" id="btn_upd_mar_{{ $nameModule }}" title="Actualizar" class="btn btn-xs btn-outline btn-success add-tooltip"><i class="fa fa-pencil-square-o"></i></a>
                                    <a href="#" onclick="deleteMarca();" title="Eliminar" class="btn btn-xs btn-outline btn-danger add-tooltip"><i class="fa fa-times"></i></a>       
                                </label>
                                <select id="marcaId" name="marcaId" class="form-control" >
                                    <option value="">[TODOS]</option> 
                                </select>           
                            </div>
                        </div>
<!--                         <div class="col-md-2">
                            <label class="control-label no-margin-b">C&oacute;digo</label>
                            <input type="text" name="cod" id="cod" placeholder="" class="form-control" style="margin-top: 10px;" autocomplete="off"/>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label no-margin-b">Descripci&oacute;n</label>
                            <input type="text" name="pro" id="pro" placeholder="" class="form-control" style="margin-top: 10px;" autocomplete="off"/>
                        </div> -->
                                    
                        <div class="col-md-1">
                            <label class="control-label no-margin-b"> &nbsp; </label>
                            <button type="" class="btn btn-success btn-block" >
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</form>   
<div class="" style="margin-top: 10px;" id="mensaje">
    <button type="button" class="close" onclick="eliminaramensaje();">×</button>
    <strong><span id="respuesta"></span></strong>
</div>
<div class="table-light table-responsive">
    {{-- <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example"> --}}
    <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer" id="jq-datatables-{{ $nameModule }}" width="100%">
			<thead>
				 <tr>
{{--                     <th style="text-align: center;">CLASIFICACIÓN</th>
                    <th style="text-align: center;">CATEGORIA</th>   
                    <th style="text-align: center;">MARCA</th> --}}  
                    <th style="text-align: center;">U. MED.</th>
                    <th style="text-align: center;">DESCRIPCIÓN</th>         
                    <th style="text-align: center;">PRECIO</th>  
                    <th style="text-align: center;">IMAGEN</th>
                    <th style="text-align: center;">ESTADO</th>             
                    <th ></th>
				</tr>	
			</thead>
        <tbody>
        </tbody>
    </table>
</div>
<hr class="no-grid-gutter-h">
<br><br>

<div id="modal-{{ $nameModule }}" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-max">
        <div class="modal-content" id="content-modal-{{ $nameModule }}">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<div id="modal-btn-{{ $nameModule }}" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="content-modal-btn-{{ $nameModule }}">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->  

<script>
init.push(function () {
    cboClasificacion('1', '-1');
    cboMarca('1', '-1');        
    $("#mensaje").hide();
    $("#clasificacionId2").select2({
        allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });

    $("#categoriaId").select2({
        allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });

    $("#marcaId").select2({
        allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });

    $("#find-{{ $nameModule }}-form").validate({
        focusInvalid: true,
        // rules: {
        //     'fec': {required: true},
        //     'fecFin': {required: true},
        // },
        // messages: {
        //     'fec': 'Seleccione fecha inicio',
        //     'fecFin': 'Seleccione fecha final',
        
        // },
        submitHandler: function(form) {
            var query_string = $.param({
                "_token": "{{ csrf_token() }}",
                "cla": $("#clasificacionId2").val(),
                "cat": $("#categoriaId").val(),
                "mar": $("#marcaId").val()
            });
            var ajax_source = "{{ url('api') }}.{{ $nameModule }}?" + query_string;
            oTable.ajax.url(ajax_source).load();
        } 
    });
   
});

/* DataTable */
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource ) {
    if ( typeof sNewSource != 'undefined' )
        oSettings.sAjaxSource = sNewSource;
 
    this.fnClearTable( this );
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
 
    $.getJSON( oSettings.sAjaxSource, null, function(json) {
        for ( var i=0 ; i<json.aaData.length ; i++ ) {
            that.oApi._fnAddData( oSettings, json.aaData[i] );
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        that.fnDraw( that );
        that.oApi._fnProcessingDisplay( oSettings, false );
    });
}

var oTableOptions = {
    "ordering": false,
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
        // {"targets": 0, 'data': 'nomClasificacion', 'nomClasificacion':'f_hor_fac'},
        // {"targets": 1, 'data': 'nomCategoria', 'name':'nomCategoria'},
        // {"targets": 2, 'data': 'nomMarca', 'name':'nomMarca', 'orderable': false},
        {"targets": 0, 'data': 'nomUnidadMedida', 'name':'nomUnidadMedida'},
		{"targets": 1, 'data': 'c_nom', 'name':'c_nom', "class": "col-md-6"},
        {"targets": 2, 'data': 'precio', 'name':'precio', 'orderable': false },
        {"targets": 3, 'data': 'img', 'name':'img', 'orderable': false, 'class': 'text-center' },
		{"targets": 4, 'data': 'estado', 'name':'estado', 'orderable': false },
        {"targets": 5, 'data': 'action', 'name': 'action', 'orderable': false, 'searchable': false}
        
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

$('#jq-datatables-{{ $nameModule }} tbody').on( 'dblclick', 'tr', function () {
    // var data = oTable.row($(this)).data(); 
    // var idJson = JSON.stringify(data.pk_cpb_id);
    // var id = idJson.replace(/['"]+/g, '');
    // detalleComprobante(id) 
}); 

function cboClasificacion(id, id2){
    var dato;
    if(id=="1"){
        dato="clasificacionId2";
    }else{
        dato="clasificacionId";
    }
    $.ajax({
        type: "GET",
        url: "{{ url('clasificacion/cboClasificacion') }}/"+id+"/"+id2,
        data: '',
        success: function(response) {
            $("#"+dato).select2('data', null, false);
            $("#"+dato).html(response);
            $("#"+dato).select2({
                //allowClear: true,
                placeholder: "SELECCIONE...",
                //minimumInputLength: 3,
                //multiple: false,
            });
        },
        error: function(e){
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo cargar clasificaci&oacute;n!" , size: 'large' });
        },
        dataType: 'html'
    });  
}

function cboCategoria(id, id2, id3){
    var dato;
    if(id2=="1"){
        dato="categoriaId";
    }else{
        dato="categoria";
    }
    $.ajax({
        type: "GET",
        url: "{{ url('categoria/cboCategoria') }}/"+id+"/"+id2+"/"+id3,
        data: '',
        success: function(response) {
            $("#"+dato).select2('data', null, false);
            $("#"+dato).html(response);
            $("#"+dato).select2({
                //allowClear: true,
                placeholder: "SELECCIONE...",
                //minimumInputLength: 3,
                //multiple: false,
            });
        },
        error: function(e){
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo cargar categoria!" , size: 'large' });
        },
        dataType: 'html'
    });  
}

function cboMarca(id, id2){
    var dato;
    if(id=="1"){
        dato="marcaId";
    }else{
        dato="marca";
    }
    $.ajax({
        type: "GET",
        url: "{{ url('marca/cboMarca') }}/"+id+"/"+id2,
        data: '',
        success: function(response) {
            $("#"+dato).select2('data', null, false);
            $("#"+dato).html(response);
            $("#"+dato).select2({
                //allowClear: true,
                placeholder: "SELECCIONE...",
                //minimumInputLength: 3,
                //multiple: false,
            });
        },
        error: function(e){
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo cargar marca!" , size: 'large' });
        },
        dataType: 'html'
    });  
}


$('#{{ $btnCreate }}').click(function() {
    var data = "";
    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });
    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");
            $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp; Creando...');                    
            $('#{{ $btnCreate }}').attr({
                'class': "btn btn-primary btn-labeled disabled",
            });             
        },
        type: "GET",
        cache: false,
        url: "{{ url('producto/create') }}",
        data: data,
        success: function(response){
            if (response != "false") {  
                $('#content-modal-{{ $nameModule }}').html(response);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span> Nuevo');                   
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                }); 
                $("#cargaCategoriaIndex").html("<select id='categoriaId' name='categoriaId' class='form-control' ><option value=''>[TODOS]</option></select>");
            }else{
                alert("No se creo el producto "+response.error);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span> Nuevo');                   
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
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span> Nuevo');                   
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

function renderUpdate(id){

    $('#modal-{{ $nameModule }}').modal({
        show:true,
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");
        },
        type: 'GET',
        cache: false,
        url: "{{ url('/producto') }}/"+id+"/edit",
        success:function(response){
            if (response != "false") {  
                $('#content-modal-{{ $nameModule }}').html(response);
                $.growl({ title: "OK:", message: "Se cargo producto ó Servicio", size: 'large' });   
            }else{
                alert("No se creo producto "+response.error);
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


function clasificacionModal(){
    var data = "";

    $('#modal-btn-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");                    
            $('#btn_cla_{{ $nameModule }}').attr({
                'class': "btn btn-xs btn-outline btn-primary add-tooltip disabled",
            });                 
        },
        type: "GET",
        cache: false,
        url: "{{ url('clasificacion/create') }}",
        data: data,
        success: function(response){
            if (response != "false") {
                $('#content-modal-btn-{{ $nameModule }}').html(response);
                $('#btn_cla_{{ $nameModule }}').attr({
                  'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                });         
            }else{
                alert("No se creo la clasificación "+response.error);
                $('#btn_cla_{{ $nameModule }}').attr({
                  'class': "btn btn-xs btn-outline btn-primary add-tooltip",
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
                $("#content-modal-btn-{{ $nameModule }}").html('');              
                $('#btn_cla_{{ $nameModule }}').attr({
                  'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                });
                
                $('#modal-btn-{{ $nameModule }}').modal('hide');
            }, 4000);   

        },
        dataType : 'html'
    });
}

function categoriaModal(){
    var id = "id="+$("#clasificacionId2").val();
    if($("#clasificacionId2").val()==""){
        bootbox.confirm({
            title: "Tiene que seleccionar clasificaci&oacute;n?",
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
                }
            },
            className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
            locale: "es",
            closeButton: false,
        });
    }else{
        $('#modal-btn-{{ $nameModule }}').modal({
            show:true 
        });

        $.ajax({
            beforeSend: function(){
                $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");
                $('#btn_cat_{{ $nameModule }}').attr({
                    'class': "btn btn-xs btn-outline btn-primary add-tooltip disabled",
                });                 
            },
            type: "GET",
            cache: false,
            url: "{{ url('categoria/create') }}/"+$("#clasificacionId2").val(),
            success: function(response){
                if (response != "false") {
                    $('#content-modal-btn-{{ $nameModule }}').html(response);
                    $('#btn_cat_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });   
                }
                else
                {
                    alert("No se creo el producto "+response.error);
                    $('#btn_cat_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
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
                    $("#content-modal-btn-{{ $nameModule }}").html('');              
                    $('#btn_cat_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });
                    
                    $('#modal-btn-{{ $nameModule }}').modal('hide');
                }, 4000);   
            },
            dataType : 'html'
        });
    }
}

function marcaModal(){
        $('#modal-btn-{{ $nameModule }}').modal({
            show:true 
        });
        $.ajax({
            beforeSend: function(){
                $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");
                $('#btn_mar_{{ $nameModule }}').attr({
                    'class': "btn btn-xs btn-outline btn-primary add-tooltip disabled",
                });                 
            },
            type: "GET",
            cache: false,
            url: "{{ url('marca/create') }}",
            success: function(response){
                if (response != "false") {
                    $('#content-modal-btn-{{ $nameModule }}').html(response);
                    $('#btn_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });         
                }
                else
                {
                    alert("No se creo el producto "+response.error);
                    $('#btn_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
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
                    $("#content-modal-btn-{{ $nameModule }}").html('');              
                    $('#btn_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });
                    
                    $('#modal-btn-{{ $nameModule }}').modal('hide');
                }, 4000);   
            },
            dataType : 'html'
        });
    }

function renderUpdateCategoria(){
    var idCla = $("#clasificacionId2").val();  
    var idCat = $("#categoriaId").val();  
    if($("#clasificacionId2").val()=="" ){
        bootbox.confirm({
            title: "Tiene que seleccionar clasificación ",
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
                }
            },
            className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
            locale: "es",
            closeButton: false,
        });

     }else{
        if($("#categoriaId").val()=="" ){
            bootbox.confirm({
                title: "Tiene que seleccionar categoria?",
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
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
               });
            }else{                                                            
                $('#modal-btn-{{ $nameModule }}').modal({
                    show:true 
                });
        
                $.ajax({
                    beforeSend: function(){
                        $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");                    
                        $('#btn_upd_cat_{{ $nameModule }}').attr({
                            'class': "btn btn-xs btn-outline btn-success add-tooltip disabled",
                        });                                     
                    },
                    type: "GET",
                    cache: false,
                    url: "{{ url('/categoria') }}/"+idCla+"/"+idCat+"/edit",
                    success: function(response){
                        if (response != "false") {
                            $('#content-modal-btn-{{ $nameModule }}').html(response);
                            $('#btn_upd_cat_{{ $nameModule }}').attr({
                              'class': "btn btn-xs btn-outline btn-success add-tooltip",
                            });             
                        }else{
                            alert("No se creo el producto "+response.error);
                            $('#btn_upd_cat_{{ $nameModule }}').attr({
                              'class': "btn btn-xs btn-outline btn-success add-tooltip",
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
                            $("#content-modal-btn-{{ $nameModule }}").html('');              
                            $('#btn_upd_cat_{{ $nameModule }}').attr({
                              'class': "btn btn-xs btn-outline btn-success add-tooltip",
                            });
                            
                            $('#modal-btn-{{ $nameModule }}').modal('hide');
                        }, 4000);
                    },
                    dataType : 'html'
                });
                return false;               
            }                
     } 
}

 function renderUpdateMarca(){
    var id = $("#marcaId").val();  
    if($("#marcaId").val()==""){
        bootbox.confirm({
            title: "Tiene que seleccionar marca?",
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
                }
            },
            className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
            locale: "es",
            closeButton: false,
        });

    }else{  
        $('#modal-btn-{{ $nameModule }}').modal({
            show:true 
        });

        $.ajax({
            beforeSend: function(){
                $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");                    
                $('#btn_upd_mar_{{ $nameModule }}').attr({
                    'class': "btn btn-xs btn-outline btn-success add-tooltip disabled",
                });                                     
            },
            type: "GET",
            cache: false,
            url: "{{ url('/marca') }}/"+id+"/edit",
            success: function(response){
                if (response != "false") {
                    $('#content-modal-btn-{{ $nameModule }}').html(response);
                    $('#btn_upd_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
                    });             
                }else{
                    alert("No se creo la marca "+response.error);
                    $('#btn_upd_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
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
                    $("#content-modal-btn-{{ $nameModule }}").html('');              
                    $('#btn_upd_mar_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
                    });
                    
                    $('#modal-btn-{{ $nameModule }}').modal('hide');
                }, 4000);
            },
            dataType : 'html'
        });
        return false; 
    }
}


function renderUpdateClasificacion(){
    var id = $("#clasificacionId2").val();  
     if($("#clasificacionId2").val()==""){
            bootbox.confirm({
                title: "Tiene que seleccionar clasificaci&oacute;n?",
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
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });

     }else{
            // ACA ENLAZAMOS EL ID DE LA CLASIFICACION PARA ANIDAR CON CATEGORIA
        // id = al id del SELECT de Clasificacion arriba  
        $('#modal-btn-{{ $nameModule }}').modal({
            show:true 
        });

        $.ajax({
            beforeSend: function(){
                $("#content-modal-btn-{{ $nameModule }}").html("{!! $loadImg !!}");                    
                $('#btn_upd_cla_{{ $nameModule }}').attr({
                    'class': "btn btn-xs btn-outline btn-success add-tooltip disabled",
                });                                         
            },
            type: "GET",
            cache: false,
            url: "{{ url('/clasificacion') }}/"+id+"/edit",
            success: function(response){
                if (response != "false") {
                    $('#content-modal-btn-{{ $nameModule }}').html(response);
                    $('#btn_upd_cla_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
                    }); 
                }else{
                    alert("No se creo el producto "+response.error);
                    $('#btn_upd_cla_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
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
                    $("#content-modal-btn-{{ $nameModule }}").html('');              
                    $('#btn_upd_cla_{{ $nameModule }}').attr({
                      'class': "btn btn-xs btn-outline btn-success add-tooltip",
                    });
                    
                    $('#modal-btn-{{ $nameModule }}').modal('hide');
                }, 4000);   

            },
            dataType : 'html'
        });
        return false;
     }      
}

function deleteClasificacion(){
    bootbox.confirm({
    title: "Seguro de eliminar clasificación?",
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
            eliminarClasificacion();
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarClasificacion(){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "{{ url('/clasificacion') }}/"+$("#clasificacionId2").val(),
        //data : data,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                $.growl.notice({
                    title: "Mensaje:",
                    message: "Se eliminó clasificación:<br />Nombre: "+$("#clasificacionId2 option:selected").text(),
                    size: 'large'
                });
                cboClasificacion('1');
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
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar clasificación!" , size: 'large' });     
        },

        dataType : 'json'
    });
}

function deleteCategoria(){
    bootbox.confirm({
    title: "Seguro de eliminar categoria?",
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
            if($("#categoriaId").val()=="" ){
            bootbox.confirm({
                title: "Tiene que seleccionar categoria?",
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
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
               });
            }else{
                eliminarCategoria();  
            }
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarCategoria(){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "{{ url('/categoria/') }}/"+$("#categoriaId").val(),
        //data : data,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                $.growl.notice({
                    title: "Mensaje:",
                    message: "Se eliminó categoria:<br />Nombre: "+$("#categoriaId option:selected").text(),
                    size: 'large'
                });
                cboCategoria($("#clasificacionId2").val(), '1');
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
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar clasificación!" , size: 'large' });     
        },

        dataType : 'json'
    });
}

function deleteMarca(){
    bootbox.confirm({
    title: "Seguro de eliminar marca?",
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
            if($("#marcaId").val()=="" ){
            bootbox.confirm({
                title: "Tiene que seleccionar marca?",
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
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
               });
            }else{
                eliminarMarca();  
            }
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarMarca(){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "{{ url('/marca/') }}/"+$("#marcaId").val(),
        //data : data,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                $.growl.notice({
                    title: "Mensaje:",
                    message: "Se eliminó marca:<br />Nombre: "+$("#marcaId option:selected").text(),
                    size: 'large'
                });
                cboMarca('1');
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
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar marca!" , size: 'large' });     
        },

        dataType : 'json'
    });
}

function renderDelete(id){        
    bootbox.confirm({
    title: "Seguro de eliminar Producto ó Servicio?",
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
            eliminarProducto(id);
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarProducto(id){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "/producto/"+id,
        url: "{{ url('/producto/') }}/"+id,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                if(datos_json.sesActiva != "0"){
                    $.growl.notice({
                        title: "Mensaje:",
                        message: "Se eliminó; producto ó servicio: <br />ID: " + id,
                        size: 'large'
                    });
                }else{
                    sessionTerminada();
                }
            }else{
                $.growl.warning({
                    title: "Mensaje:",
                    message: "No se puede eliminar el registro porque tiene relacion con otras tablas",
                    size: 'large'
                });
            }
            $('#jq-datatables-<?php echo $nameModule; ?>').dataTable().fnClearTable()
        },
        error : function(data) {
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar producto ó servicio!" , size: 'large' });
        },

        dataType : 'json'
    });
} 


</script>
@stop