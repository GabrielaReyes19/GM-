<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Contracts\Filesystem\Filesystem;

Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/create', 'ClienteController@create');
Route::post('/cliente', 'ClienteController@store');
Route::get('/cliente/{id}/edit', 'ClienteController@edit');
Route::put('/cliente/{id}/edit', 'ClienteController@update')->name('cliente.update');
Route::delete('/cliente/{id}', 'ClienteController@destroy');

Route::get('/cliente.createSunat/{doc?}', 'ClienteController@createSunat');
Route::get('api.cliente/{doc?}', 'ClienteController@apiClient');
Route::get('sunat.cliente/{doc?}', 'ClienteController@buscarRucDni');


Route::get('/profiles', 'ProfileController@index');
Route::put('/profiles/{id}/edit', 'ProfileController@update')->name('profiles.update');
Route::get('/profiles.permits/{id}', 'ProfileController@cargaPermits');

Route::get('/comprobante', 'ComprobanteController@index');
Route::get('api.comprobante/{doc?}', 'ComprobanteController@apiComprobante');
Route::get('/comprobante/create', 'ComprobanteController@create');
Route::get('cbo.cliente', 'ComprobanteController@cboCliente');
Route::get('serie/{id?}', 'ComprobanteController@cboSerie');
Route::get('cbo.producto/{id?}', 'ComprobanteController@cboProducto');
Route::post('/comprobante', 'ComprobanteController@store');

Route::get('/', function (Filesystem $filesystem) {
 
$form_numero_de_documento_emisor="20524719585";
// cabecera
$fecha_de_emision="2016-10-01";
$firma_digital="";
$apellidos_y_nombres_denominacion_o_razon_social="AVANZA SOLUCIONES S.A.C.";
$nombre_comercial="AVSO S.A.C.";
$domicilio_fiscal="150131!CAL. AGUSTIN DE LA TORRE GONZALES NRO 194!!LIMA!LIMA!SAN ISIDRO!PE";
$numero_de_RUC=$form_numero_de_documento_emisor."!6";
$tipo_de_documento_catalogo_01="01";
$numeracion_conformada_por_serie_y_numero_correlativo="FF13-00000003";
$tipo_y_numero_de_documento_de_identidad_del_adquiriente_o_usuario="20509630128!6";
$appelidos_y_nombres_del_adquiriente_o_usuario="INVERSIONES MERLOT S.A.C.";
$total_valor_de_venta_operaciones_gravadas="1001!100.00";//Total de la venta
$total_valor_de_venta_operaciones_inafectas="1002!0.00";
$total_valor_de_venta_operaciones_exoneradas="1003!0.00";
$sumatoria_IGV="18.00!18.00!1000!IGV!VAT"; //resultado = Total*18/100
$sumatoria_ISC="!!!!";
$sumatoria_otros_tributos="!!!!";
$sumatoria_otros_cargos="";
$total_descuentos="!";
$importe_total_de_la_venta_o_sesion_en_uso_o_del_servicio_prestado="118.00"; //total general 
$tipo_de_moneda_en_la_cual_se_emite_la_factura_electronica="PEN";
$tipo_y_numero_de_la_guia_de_remision_relacionada_con_la_operacion_que_se_factura="¦";
$tipo_de_numero_de_otro_documento_y_codigo_relacionado_con_la_opcion_que_se_factura="¦";
$leyendas="1000¦CIENTO DIECIOCHO Y 00/100 SOLES";
$importe_de_la_percepcion_de_la_moneda_nacional="!!!";
$version_del_UBL="2.0";
$version_de_la_estructura_del_documento="1.0";
$valor_referencial_del_servicio_de_transporte_de_bienes_realizado_por_via_terrestre="!";
$nombre_y_matricula_de_la_embarcacion_pesquera_utilizada_para_efectuar_la_extraccion="!";
$descripcion_del_tipo_y_cantidad_de_la_especie_vendida="!";
$lugar_de_la_descarga="!";
$fecha_de_la_descarga="!";
$numero_de_registro_MTC="!";
$configuracion_vehicular="!";
$punto_de_origen="!";
$punto_de_destino="!";
$valor_referencial_preliminar="!";
$fecha_de_consumo="!";
$total_valor_de_venta_operaciones_gratuitas="";
$descuentos_globales="";
$porcentaje_de_detraccion="";
$codigo_de_bienes_y_servicios_sujetos_al_sistema="";
$numero_de_cuenta_del_proveedor_en_el_banco_de_la_nacion="";
$orden_de_compra="";
$condiciones_de_pago="";
$fecha_de_vencimiento="12-12-2016";
$observacion="";
$direccion_del_cliente="AVDA. 2 DE MAYO 798 SAN ISIDRO SAN ISIDRO-LIMA";
$correo_del_cliente="marianatagami@gmail.com";
$tipo_de_cambio="3.402";
$extraOficial_paciente="";
$extraOficial_prf_nro="";
$extraOficial_plan="";
$extraOficial_caja="";
$extraOficial_s_caja="";
$extraOficial_usuario="MJARAMILLO";
$extraOficial_correo_contacto="www.avanzasoluciones.com.pe";
$extraOficial_cf="";
$extraOficial_sf="";
///////////////////////////////////////////////////////////////////////////////

// detalle itemsDocumento
$unidad_de_medida_por_item="NIU";
$cantidad_de_unidades_por_item="1.00";
$descripcion_detallada_del_servicio_prestado="SERVICIO DE ADMINISTRACIÓN WIFI SOCIAL";
$valor_unitario_por_item="100.00";
$precio_de_venta_unitario_por_item_y_codigo="118.00!01";
$afectacion_al_IGV_por_item="18.00!18.00!10!1000!IGV!VAT";
$sistema_de_ISC_por_item="!!!!!";
$valor_de_venta_por_item="100.00";
$numero_de_orden_del_item="1";
$codigo_del_producto="101";
$valor_referencial_unitario_por_item_en_operaciones_no_onerosas_y_codigo="!";
$descuentos_por_item="!";


$cabecera= $fecha_de_emision."|".
		$firma_digital."|".
		$apellidos_y_nombres_denominacion_o_razon_social."|".
		$nombre_comercial."|".
		$domicilio_fiscal."|".
		$numero_de_RUC."|".
		$tipo_de_documento_catalogo_01."|".
		$numeracion_conformada_por_serie_y_numero_correlativo."|".
		$tipo_y_numero_de_documento_de_identidad_del_adquiriente_o_usuario."|".
		$appelidos_y_nombres_del_adquiriente_o_usuario."|".
		$total_valor_de_venta_operaciones_gravadas."|".
		$total_valor_de_venta_operaciones_inafectas."|".
		$total_valor_de_venta_operaciones_exoneradas."|".
		$sumatoria_IGV."|".
		$sumatoria_ISC."|".
		$sumatoria_otros_tributos."|".
		$sumatoria_otros_cargos."|".
		$total_descuentos."|".
		$importe_total_de_la_venta_o_sesion_en_uso_o_del_servicio_prestado."|".
		$tipo_de_moneda_en_la_cual_se_emite_la_factura_electronica."|".
		$tipo_y_numero_de_la_guia_de_remision_relacionada_con_la_operacion_que_se_factura."|".
		$tipo_de_numero_de_otro_documento_y_codigo_relacionado_con_la_opcion_que_se_factura."|".
		$leyendas."|".
		$importe_de_la_percepcion_de_la_moneda_nacional."|".
		$version_del_UBL."|".
		$version_de_la_estructura_del_documento."|".
		$valor_referencial_del_servicio_de_transporte_de_bienes_realizado_por_via_terrestre."|".
		$nombre_y_matricula_de_la_embarcacion_pesquera_utilizada_para_efectuar_la_extraccion."|".
		$descripcion_del_tipo_y_cantidad_de_la_especie_vendida."|".
		$lugar_de_la_descarga."|".
		$fecha_de_la_descarga."|".
		$numero_de_registro_MTC."|".
		$configuracion_vehicular."|".
		$punto_de_origen."|".
		$punto_de_destino."|".
		$valor_referencial_preliminar."|".
		$fecha_de_consumo."|".
		$total_valor_de_venta_operaciones_gratuitas."|".
		$descuentos_globales."|".
		$porcentaje_de_detraccion."|".
		$codigo_de_bienes_y_servicios_sujetos_al_sistema."|".
		$numero_de_cuenta_del_proveedor_en_el_banco_de_la_nacion."|".
		$orden_de_compra."|".
		$condiciones_de_pago."|".
		$fecha_de_vencimiento."|".
		$observacion."|".
		$direccion_del_cliente."|".
		$correo_del_cliente."|".
		$tipo_de_cambio."|".
		$extraOficial_paciente."|".
		$extraOficial_prf_nro."|".
		$extraOficial_plan."|".
		$extraOficial_caja."|".
		$extraOficial_s_caja."|".
		$extraOficial_usuario."|".
		$extraOficial_correo_contacto."|".
		$extraOficial_cf."|".
		$extraOficial_sf."|"."\n";

$detalle = $unidad_de_medida_por_item."|".
			$cantidad_de_unidades_por_item."|".
			$descripcion_detallada_del_servicio_prestado."|".
			$valor_unitario_por_item."|".
			$precio_de_venta_unitario_por_item_y_codigo."|".
			$afectacion_al_IGV_por_item."|".
			$sistema_de_ISC_por_item."|".
			$valor_de_venta_por_item."|".
			$numero_de_orden_del_item."|".
			$codigo_del_producto."|".
			$valor_referencial_unitario_por_item_en_operaciones_no_onerosas_y_codigo."|".
			$descuentos_por_item."|";


	$datos=$cabecera.$detalle;
	

    $value = $fecha_de_emision;
    $line = explode('-', $value);

    $fecha_archivo_sunat=$line[2].$line[1].$line[0];
	$filesystem->put(
						$fecha_archivo_sunat.'-'.
						$form_numero_de_documento_emisor.'-'.
						$tipo_de_documento_catalogo_01.'-'.
						$numeracion_conformada_por_serie_y_numero_correlativo.'.txt', $datos
					);

 	$file = storage_path('app\/'.
						$fecha_archivo_sunat.'-'.
						$form_numero_de_documento_emisor.'-'.
						$tipo_de_documento_catalogo_01.'-'.
						$numeracion_conformada_por_serie_y_numero_correlativo.'.txt'
 						);
 
    $client = new GuzzleHttp\Client(['base_uri' => 'http://127.0.0.1:8888']);
    $response = $client->post('/api/process-txt',
        [
            'http_errors'=>true,
            'headers' => [
                'Accept' => 'application/json',
             ],
            'multipart' => [
                [
                    'name'     => 'text_plain',
                    'contents' => fopen($file, 'r'),
                    'filename' => $fecha_archivo_sunat.'-'.
								  $form_numero_de_documento_emisor.'-'.
								  $tipo_de_documento_catalogo_01.'-'.
								  $numeracion_conformada_por_serie_y_numero_correlativo.'.txt'
                ]
            ]
        ]);
    $contents = (string) $response->getBody()->getContents();
    $result = json_decode($contents, true);
    return $result;

});



// Route::get('/', function (Filesystem $filesystem) {
// 	$client = new GuzzleHttp\Client();

// 	//App factura
// 	$base_api = "http://127.0.0.1:8888/";
// 	$endpoint = "/api/process-txt";


// 	$numero_de_RUC = "20524719585";
// 	$numeracion_conformada_por_serie_y_numero_correlativo = "FF11-00000002";

// 	$data_json = 
// 	'{
// 	  "cabeceraDocumento": [
// 	    {
// 	      "fecha_de_emision": "2016-12-12",
// 	      "firma_digital": "",      
// 	      "apellidos_y_nombres_denominacion_o_razon_social": "AVANZA SOLUCIONES S.A.C.",      
// 	      "nombre_comercial": "AVSO S.A.C.",      
// 	      "domicilio_fiscal": "150131!CAL. AGUSTIN DE LA TORRE GONZALES NRO 194!!LIMA!LIMA!SAN ISIDRO!PE",      
// 	      "numero_de_RUC": "'.$numero_de_RUC.'!6",     
// 	      "tipo_de_documento_catalogo_01": "01",      
// 	      "numeracion_conformada_por_serie_y_numero_correlativo": "'.$numeracion_conformada_por_serie_y_numero_correlativo.'",      
// 	      "tipo_y_numero_de_documento_de_identidad_del_adquiriente_o_usuario": "20509630128!6",     
// 	      "appelidos_y_nombres_del_adquiriente_o_usuario": "INVERSIONES MERLOT S.A.C.",     
// 	      "total_valor_de_venta_operaciones_gravadas": "1001!100.00",     
// 	      "total_valor_de_venta_operaciones_inafectas": "1002!0.00",      
// 	      "total_valor_de_venta_operaciones_exoneradas": "1003!0.00",     
// 	      "sumatoria_IGV": "18.00!18.00!1000!IGV!VAT",      
// 	      "sumatoria_ISC": "!!!!",      
// 	      "sumatoria_otros_tributos": "!!!!",     
// 	      "sumatoria_otros_cargos": "",     
// 	      "total_descuentos": "!",      
// 	      "importe_total_de_la_venta_o_sesion_en_uso_o_del_servicio_prestado": "118.00",      
// 	      "tipo_de_moneda_en_la_cual_se_emite_la_factura_electronica": "PEN",     
// 	      "tipo_y_numero_de_la_guia_de_remision_relacionada_con_la_operacion_que_se_factura": "¦",      
// 	      "tipo_de_numero_de_otro_documento_y_codigo_relacionado_con_la_opcion_que_se_factura": "¦",      
// 	      "leyendas": "1000¦CIENTO DIECIOCHO Y 00/100 SOLES",     
// 	      "importe_de_la_percepcion_de_la_moneda_nacional": "!!!",      
// 	      "version_del_UBL": "2.0",     
// 	      "version_de_la_estructura_del_documento": "1.0",      
// 	      "valor_referencial_del_servicio_de_transporte_de_bienes_realizado_por_via_terrestre": "!",      
// 	      "nombre_y_matricula_de_la_embarcacion_pesquera_utilizada_para_efectuar_la_extraccion": "!",     
// 	      "descripcion_del_tipo_y_cantidad_de_la_especie_vendida": "!",     
// 	      "lugar_de_la_descarga": "!",      
// 	      "fecha_de_la_descarga": "!",      
// 	      "numero_de_registro_MTC": "!",      
// 	      "configuracion_vehicular": "!",     
// 	      "punto_de_origen": "!",     
// 	      "punto_de_destino": "!",      
// 	      "valor_referencial_preliminar": "!",      
// 	      "fecha_de_consumo": "!",      
// 	      "total_valor_de_venta_operaciones_gratuitas": "",     
// 	      "descuentos_globales": "",      
// 	      "porcentaje_de_detraccion": "",     
// 	      "codigo_de_bienes_y_servicios_sujetos_al_sistema": "",      
// 	      "numero_de_cuenta_del_proveedor_en_el_banco_de_la_nacion": "",      
// 	      "orden_de_compra": "",      
// 	      "condiciones_de_pago": "",      
// 	      "fecha_de_vencimiento": "12-12-2016",     
// 	      "observacion": "",      
// 	      "direccion_del_cliente": "AVDA. 2 DE MAYO 798 SAN ISIDRO SAN ISIDRO-LIMA",      
// 	      "correo_del_cliente": "marianatagami@gmail.com",      
// 	      "tipo_de_cambio": "3.402",      
// 	      "extraOficial_paciente": "",      
// 	      "extraOficial_prf_nro": "",     
// 	      "extraOficial_plan": "",      
// 	      "extraOficial_caja": "",      
// 	      "extraOficial_s_caja": "",      
// 	      "extraOficial_usuario": "MJARAMILLO",     
// 	      "extraOficial_correo_contacto": "www.avanzasoluciones.com.pe",      
// 	      "extraOficial_cf": "",      
// 	      "extraOficial_sf": ""
// 	    }
// 	  ],
// 	  "itemsDocumento": [
// 	    {
// 	      "unidad_de_medida_por_item": "NIU",
// 	      "cantidad_de_unidades_por_item": "1.00",
// 	      "descripcion_detallada_del_servicio_prestado": "SERVICIO DE ADMINISTRACIÓN WIFI SOCIAL",
// 	      "valor_unitario_por_item": "100.00",
// 	      "precio_de_venta_unitario_por_item_y_codigo": "118.00!01",
// 	      "afectacion_al_IGV_por_item": "18.00!18.00!10!1000!IGV!VAT",
// 	      "sistema_de_ISC_por_item": "!!!!!",
// 	      "valor_de_venta_por_item": "100.00",
// 	      "numero_de_orden_del_item": "1",
// 	      "codigo_del_producto": "101",
// 	      "valor_referencial_unitario_por_item_en_operaciones_no_onerosas_y_codigo": "!",
// 	      "descuentos_por_item": "!"
// 	    },
// 	    {
// 	      "unidad_de_medida_por_item": "NIU",
// 	      "cantidad_de_unidades_por_item": "1.00",
// 	      "descripcion_detallada_del_servicio_prestado": "OTRO PRODUCTO",
// 	      "valor_unitario_por_item": "100.00",
// 	      "precio_de_venta_unitario_por_item_y_codigo": "118.00!01",
// 	      "afectacion_al_IGV_por_item": "18.00!18.00!10!1000!IGV!VAT",
// 	      "sistema_de_ISC_por_item": "!!!!!",
// 	      "valor_de_venta_por_item": "100.00",
// 	      "numero_de_orden_del_item": "2",
// 	      "codigo_del_producto": "102",
// 	      "valor_referencial_unitario_por_item_en_operaciones_no_onerosas_y_codigo": "!",
// 	      "descuentos_por_item": "!"
// 	    }    
// 	  ]
// 	}';


// 	//JSON TO Array
// 	$assocArray = json_decode($data_json, true);


// 	//Cabecera
// 	$master = $assocArray["cabeceraDocumento"][0];
// 	foreach($master as $k => $v) {
// 	    $values[] = $v;
// 	}
// 	$csv_master = implode('|', $values);


// 	//Detalle
// 	$detail = $assocArray["itemsDocumento"];
// 	foreach($detail as $line) {

// 	    $values2 = array();
// 	    foreach($line as $k2 => $v2) {  

// 	        $values2[] = $v2;

// 	    }
// 	    $csv_detail[] = implode('|', $values2);

// 	}
// 	$csv_detail = implode(PHP_EOL, $csv_detail);
// 	//die(var_dump($csv_detail));


// 	//Generated TXTs
// 	$path = "txt_generated/";
// 	$name = date('dmY')."-".$numero_de_RUC."-01-".$numeracion_conformada_por_serie_y_numero_correlativo.".txt";
// 	//dd($path .'/' .$name, $csv_master . PHP_EOL . $csv_detail);
// 	//file_put_contents($path .'/' .$name, $csv_master . PHP_EOL . $csv_detail);
// 	$filesystem->put($name, $csv_master . $csv_detail);
//  	$file = storage_path('app\/'.$name.'');
//  	$client = new GuzzleHttp\Client(['base_uri' => $base_api]);
//     $response = $client->post($endpoint,
//         [
//             'http_errors'=>true,
//             'headers' => [
//                 'Accept' => 'application/json',
//              ],
//             'multipart' => [
//                 [
//                     'name'     => 'text_plain',
//                     'contents' => fopen($file, 'r'),
//                     'filename' => $file
//                 ]
//             ]
//         ]);
//     $contents = (string) $response->getBody()->getContents();
//     $result = json_decode($contents, true);
//     return $result;
// });