<div class="panel panel-info panel-dark no-margin">
	<div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">SUNAT - Consulta RUC</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="panel widget-messages">
    				<!--<div class="panel-heading">
    					<span class="panel-title"><i class="panel-title-icon fa fa-envelope-o"></i>Messages</span>
    				</div>  / .panel-heading -->
    				<div class="panel-body" style="padding-top: 0px; padding-top: 0px;">
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">RUC:</a>
    						<a title="" class="title" style="padding-right: 5px;"><span id="wRuc"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Tipo Contribuyente:</a>
    						<a title="" class="title" style="padding-right: 5px;"><span id="wTipCon"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Nombre Comercial:</a>
    						<a title="" class="title" style="padding-right: 5px;"><span id="wNomCome"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Fecha de Inscripci&oacute;n:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wFecIns"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Estado del Contribuyente:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wEstCon"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Condici&oacute;n del Contribuyente:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wEstConCont"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Direcci&oacute;n del Domicilio Fiscal:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wDirDomFis"></span></a>
    					</div> <!-- / .message -->
    
    					<div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Sistema de Emisi&oacute;n de Comprobante:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wSisEmiCom"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Actividad de Comercio Exterior:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wActCom"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Sistema de Contabilidad:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wSisCont"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Profesi&oacute;n u Oficio:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wProOfi"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Emisor electr&oacute;nico desde:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wEmiEle"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Afiliado al PLE desde:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wAfiPle"></span></a>
    					</div> <!-- / .message -->
                        
                        <div class="message unread">
    						<a title="" class="from" style="min-width: 230px;">Tel&eacute;fono:</a>
                            <a title="" class="title" style="padding-right: 5px;"><span id="wTel"></span></a>
    					</div> <!-- / .message -->
    
    				</div> <!-- / .panel-body -->
    			</div> <!-- / .panel -->
            </div>
        </div>
        <div class="text-right ">
            <button type="button" class="btn btn-danger btn-outline" id="" data-dismiss="modal">
    			<span class="btn-label icon fa fa-times"></span> Cerrar
    		</button>
    	</div>  
    </div>
</div>
<input type="hidden" id="idDoc" value="{{ $ruc_dni }}"/>
<script type="text/javascript">

    $( document ).ready(function() {
        busquedaSunat();
    });
    
    function busquedaSunat(){
     $.ajax({
    	beforeSend: function(){
    	},
    	type : 'GET',
    	url: '{{ url('sunat.cliente') }}/'+$("#idDoc").val(),
        // data: { 
        //     id:$("#idDoc").val()
        // },
    	success : function(datos_json) {	
    		if (datos_json.success != false) {
  		        if(datos_json.sesActiva != "0"){
                    $("#wRuc").text(datos_json['result']['RUC']+" - "+datos_json['result']['RazonSocial']);
                    $("#wTipCon").text(datos_json['result']['Tipo']);
                    $("#wNomCome").text(datos_json['result']['NombreComercial']);
                    $("#wFecIns").text(datos_json['result']['Inscripcion']);
                    $("#wEstCon").text(datos_json['result']['Estado']);
                    $("#wEstConCont").text(datos_json['result']['Condicion']);
                    $("#wDirDomFis").text(datos_json['result']['Direccion']);
                    $("#wSisEmiCom").text(datos_json['result']['SistemaEmision']);
                    $("#wActCom").text(datos_json['result']['ActividadExterior']);                    
                    $("#wSisCont").text(datos_json['result']['SistemaContabilidad']);
                    $("#wProOfi").text(datos_json['result']['Oficio']);
                    $("#wEmiEle").text(datos_json['result']['EmisionElectronica']);
                    $("#wAfiPle").text(datos_json['result']['PLE']);
                    $("#wTel").text(datos_json['result']['Telefono']);    
                }else{
                    sessionTerminada();
                }
    		}else{
    		    alert(datos_json.msg)
    		}
    	},
    	error : function(data) {
    		$.growl.error({ title: "Error:", message: "No se pudo mostrar el detalle del producto!", size: 'large' });
    	},
    
        	dataType : 'json'
        });
        
    }