<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus" style="font-size: 25px;"></i> <span id="titulo" style="font-size: 28px;">RESUMEN: {{ $id2 }}</span></span>
</div>
<div class="modal-body">
    <div class="table-light table-responsive">
        <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer" id="jq-datatables-{{ $nameModule }}-show" width="100%">
                <thead>
                     <tr>
                        <th style="text-align: center;">FECHA DE DOCUMENTO</th>
                        <th style="text-align: center;">TIPO</th>
                        <th style="text-align: center;">SERIE</th>
                        <th style="text-align: center;">NÚMERO</th>
                        <th style="text-align: center;">CLIENTE</th>   
                        <th style="text-align: center;">MONEDA</th>          
                        <th style="text-align: center;">TOTAL</th>
                        <th style="text-align: center;">ACEPTADA</th> 
                        <th style="text-align: center;">ANULADA</th>           
                    </tr>   
                </thead>
            <tbody>
            </tbody>
        </table>
    </div> 
</div>
<script type="text/javascript">
$(document).ready(function (){
});  

var oTableOptions2 = {
    "order": [[ 0, "ASC" ]],
    //"lengthMenu": [ [10, 20, 50], [10, 20, 50] ],
    "lengthMenu": [ [10, 15, 20, -1], [10, 15, 20, "Todos"] ],
    "pageLength": 100,
    "processing": true,
    "serverSide": true,
    "pagingType": "full_numbers",
    "stateSave": false,
    
    "ajax":{
    "url": "{{ url('api') }}.{{ $linkBaseModule }}_show/{{ $id }}",
    "type": "GET",
        /*"data": function ( d ) {
            d.extra_search = $('#extra').val();
        }*/
    },

    "columnDefs": 
    [
        {"targets": 0, 'data': 'f_hor_fac', 'name': 'f_hor_fac', "class": "col-md-2", "orderable": false},
        {"targets": 1, 'data': 'c_des', 'name':'c_des', "class": "col-md-3", "orderable": false},
        {"targets": 2, 'data': 'c_num_ser', 'name':'c_num_ser', "class": "col-md-1", "orderable": false},
        {"targets": 3, 'data': 'numero', 'name':'numero', "class": "col-md-1"},
        {"targets": 4, 'data': 'cliente', 'name':'cliente', "class": "col-md-4", "orderable": false},
        {"targets": 5, 'data': 'c_abr', 'name':'c_abr', "class": "col-md-1", "orderable": false},
        {"targets": 6, 'data': 'n_tot', 'name':'n_tot', "class": "col-md-1", "orderable": false},
        {"targets": 7, 'data': 'aceptada', 'name':'aceptada', "orderable": false},
        {"targets": 8, 'data': 'anulada', 'name':'anulada', "orderable": false},
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
    "sDom": ' t <"padding-xs-hr" <"table-caption no-padding"> <"clear"T> <"DT-lf-right"> > t <"table-footer padding-xs-hr clearfix" <"DT-label"i> <"DT-pagination"p> >',
            "oTableTools": {        
        "aButtons": [
        ]           
    }    
};

var oTable2 = $('#jq-datatables-{{ $nameModule }}-show').DataTable(
    oTableOptions2
);

$('#jq-datatables-{{ $nameModule }}-show').on( 'draw.dt', function () {

});


</script>

