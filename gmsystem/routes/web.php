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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/acceder', 'AccederController@index');
Route::post('/acceder/acceso', 'AccederController@acceso');

Route::post('correo','CorreoController@getCorreo');

Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/create', 'ClienteController@create');
Route::post('/cliente', 'ClienteController@store');
Route::get('/cliente/{id}/edit', 'ClienteController@edit');
Route::put('/cliente/{id}/edit', 'ClienteController@update')->name('cliente.edit');
Route::delete('/cliente/{id}', 'ClienteController@destroy');
Route::get('cliente.otros', 'ClienteController@otros');

Route::get('/cliente.createSunat/{doc?}', 'ClienteController@createSunat');
Route::post('api.cliente', 'ClienteController@apiClient');
Route::get('sunat.cliente/{doc?}', 'ClienteController@buscarRucDni');

Route::get('departamento/{id?}', 'ClienteController@departamento');
Route::get('provincia/{id?}/{id2?}', 'ClienteController@provincia');
Route::get('distrito/{id?}/{id2?}', 'ClienteController@distrito');


Route::get('/profiles', 'ProfileController@index');
Route::put('/profiles/{id}/edit', 'ProfileController@update')->name('profiles.update');
Route::get('/profiles.permits/{id}', 'ProfileController@cargaPermits');

Route::get('/comprobante', 'ComprobanteController@index');
Route::post('api.comprobante', 'ComprobanteController@apiComprobante');
Route::get('comprobante/create/{id?}/{id2?}', 'ComprobanteController@create');

Route::get('/comprobante/{id}/{id2}/edit', 'ComprobanteController@edit');
Route::get('comprobante/createCorreo/{id?}/{id2?}', 'ComprobanteController@createCorreo');
Route::get('cbo.cliente/{id?}', 'ComprobanteController@cboCliente');
Route::get('serie/{id?}/{id2?}/{id3?}/{id4?}', 'ComprobanteController@cboSerie');
Route::get('cbo.producto/{id?}/{id2?}', 'ComprobanteController@cboProducto');
Route::post('/comprobante', 'ComprobanteController@store');
Route::post('/comprobante/reenviar', 'ComprobanteController@storeReenviar');
Route::post('/comprobante/anular', 'ComprobanteController@anular');
Route::get('/reImprimir/{id}', 'ComprobanteController@reImprimir');

Route::post('/comprobanteBorrador', 'ComprobanteController@storeBorrador');

Route::get('datos.cliente/{id?}', 'ComprobanteController@datosCliente');
Route::get('datos.producto/{id?}/{id2?}', 'ComprobanteController@datosProducto');
Route::get('datos.productoComprobante/{id?}/{id2?}', 'ComprobanteController@datosProductoComprobante');
Route::get('/producto/search', 'ComprobanteController@searchProducto');

Route::post('/correo', 'ComprobanteController@procesarSinCorreo');
Route::get('/comprobante/createAnulado/{id?}', 'ComprobanteController@createAnulado');
Route::get('/comprobante/createAnuladoBoleta/{id?}', 'ComprobanteController@createAnuladoBoleta');
Route::get('/comprobante/createCliente/{id?}/{id2?}', 'ComprobanteController@createCliente');
Route::get('/comprobante/imprimirComprobante/{id?}', 'ComprobanteController@imprimirComprobante');
Route::get('/comprobante/detalleComprobante/{id?}', 'ComprobanteController@detalleComprobante');
Route::delete('/comprobante/{id}', 'ComprobanteController@destroy');
Route::get('comprobante/pdf', 'ComprobanteController@pdf');

Route::get('/reporteTotalVentas', 'ReporteTotalVentasController@index');
Route::get('reporteTotalVentas/imprimir', 'ReporteTotalVentasController@imprimir');
Route::get('reporteTotalVentas/pdf', 'ReporteTotalVentasController@pdf');

Route::get('/documentos_anulados', 'DocumentosAnuladosController@index');
Route::get('/documentos_anulados/create', 'DocumentosAnuladosController@create');
// Route::get('api.documentos_anulados/{fecha?}', 'DocumentosAnuladosController@apidocumentoAnulado');
Route::post('/documentos_anulados', 'DocumentosAnuladosController@store');
Route::post('api.facturaRa', 'DocumentosAnuladosController@apiFacturaRa');
Route::post('/documentos_anulados/procesar_ticket', 'DocumentosAnuladosController@procesarTicket');

Route::get('/resumen_diario', 'ResumenDiarioBoletaController@index');
Route::get('api.resumen_diario/{fecha?}', 'ResumenDiarioBoletaController@apiResumenDiario');
Route::get('/resumen_diario/create', 'ResumenDiarioBoletaController@create');
Route::post('api.resumenRc', 'ResumenDiarioBoletaController@apiresumenRc');
Route::get('resumen_diario/contar/{fecha?}', 'ResumenDiarioBoletaController@contar');
Route::post('/resumen_diario', 'ResumenDiarioBoletaController@store');
Route::post('/resumen_diario/procesar_ticket', 'ResumenDiarioBoletaController@procesarTicket');
Route::get('/resumen_diario/{id}/{i2}/show', 'ResumenDiarioBoletaController@show');
Route::get('api.resumen_diario_show/{id?}', 'ResumenDiarioBoletaController@apiShowResumenDiario');

Route::get('/resumen_anulado', 'ResumenDiarioBoletaController@indexAnulado');
Route::post('/resumen_anulado', 'ResumenDiarioBoletaController@storeAnulado');
Route::post('api.resumenAnuladoRc', 'ResumenDiarioBoletaController@apiresumenAnuladoRc');

Route::get('/producto', 'ProductoServicioController@index');
Route::post('api.producto', 'ProductoServicioController@apiProductoServicio');
Route::get('/producto/create', 'ProductoServicioController@create');
Route::post('/producto', 'ProductoServicioController@store');
Route::get('/producto/{id}/edit', 'ProductoServicioController@edit');
Route::put('/producto/{id}/edit', 'ProductoServicioController@update')->name('producto.edit');
Route::delete('/producto/{id}', 'ProductoServicioController@destroy');

#Clasificación
Route::get('/clasificacion/cboClasificacion/{id?}/{id2?}', 'ClasificacionController@cboClasificacion');
Route::get('/clasificacion/create', 'ClasificacionController@create');
Route::post('/clasificacion', 'ClasificacionController@store');
Route::get('/clasificacion/{id}/edit', 'ClasificacionController@edit');
Route::put('/clasificacion/{id}/edit', 'ClasificacionController@update')->name('clasificacion.edit');
Route::delete('/clasificacion/{id}', 'ClasificacionController@destroy');

#Categoria
Route::get('/categoria/cboCategoria/{id?}/{id2?}/{id3?}', 'CategoriaController@cboCategoria');
Route::get('/categoria/create/{id?}', 'CategoriaController@create');
Route::post('/categoria', 'CategoriaController@store');
Route::get('/categoria/{id}/{id2}/edit', 'CategoriaController@edit');
Route::put('/categoria/{id}/edit', 'CategoriaController@update')->name('categoria.edit');
Route::delete('/categoria/{id}', 'CategoriaController@destroy');

#Marca
Route::get('/marca/cboMarca/{id?}/{id2?}', 'MarcaController@cboMarca');
Route::get('/marca/create', 'MarcaController@create');
Route::post('/marca', 'MarcaController@store');
Route::get('/marca/{id}/edit', 'MarcaController@edit');
Route::put('/marca/{id}/edit', 'MarcaController@update')->name('marca.edit');
Route::delete('/marca/{id}', 'MarcaController@destroy');

#Configuracion
Route::get('/configuracion', 'ConfiguracionController@index');
Route::get('/configuracion/create', 'ConfiguracionController@create');
Route::post('/configuracion', 'ConfiguracionController@store');
Route::get('/configuracion/{id}/edit', 'ConfiguracionController@edit');
Route::put('/configuracion/{id}/edit', 'ConfiguracionController@update')->name('marca.edit');
Route::delete('/configuracion/{id}', 'ConfiguracionController@destroy');
Route::post('api.configuracion', 'ConfiguracionController@apiConfiguracionServicio');

Route::post('/archivo_sunat/pdf', 'ArchivoSunatController@procesarPdf');
Route::post('/archivo_sunat/xml', 'ArchivoSunatController@procesarXml');
Route::post('/archivo_sunat/cdr', 'ArchivoSunatController@procesarCdr');
Route::post('/archivo_sunat/cdrProcessed', 'ArchivoSunatController@procesarCdrProcessed');

Route::get('test', function(){
    DB::table('users')->where('id','4')->update([
      "password" => bcrypt('797979'),
    ]);
});




