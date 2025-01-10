<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Comprobante;
use App\DocumentoComprobante;
use App\TipoOperacion;
use App\Moneda;
use App\Producto;
use App\Cliente;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use GuzzleHttp\Client;
use Mail;

class ArchivoSunatController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('redireccionaSiNoExisteSucursal');
    }

    public function procesarXml(Request $request)
    {
      $archivo_sunat=$request->input('id');
      $tipo="xml";
      $base_api = env('URL_FE');
      $endpoint = "/api/process-xml";
      $client = new Client(['base_uri' => $base_api]);
      $response = $client->post($endpoint,
      [
          'http_errors'=>true,
          'headers' => [
              'Accept' => 'application/json',
          ],
          'form_params' => [
              'archivo_sunat' => $archivo_sunat,
              'tipo' => $tipo,
              'send' => true
          ],
        ]);
        $contents = (string) $response->getBody()->getContents();
        $result = json_decode($contents, true);
        $success=TRUE;
        $datos_json = response()->json([
          'success' =>  $success,
          'result' =>  $result]);
        return $datos_json;
    }

    public function procesarCdrProcessed(Request $request)
    {
      $archivo_sunat="R-".$request->input('id');
      $tipo="cdr-processed";
      $base_api = env('URL_FE');
      $endpoint = "/api/process-xml";
      $client = new Client(['base_uri' => $base_api]);
      $response = $client->post($endpoint,
      [
          'http_errors'=>true,
          'headers' => [
              'Accept' => 'application/json',
          ],
          'form_params' => [
              'archivo_sunat' => $archivo_sunat,
              'tipo' => $tipo,
              'send' => true
          ],
        ]);
        $contents = (string) $response->getBody()->getContents();
        $result = json_decode($contents, true);
        $success=TRUE;
        $datos_json = response()->json([
          'success' =>  $success,
          'result' =>  $result]);

        return $datos_json;
    }

    public function procesarCdr(Request $request)
    {
      $archivo_sunat="R-".$request->input('id');
      $tipo="cdr";
      $base_api = env('URL_FE');
      $endpoint = "/api/process-xml";
      $client = new Client(['base_uri' => $base_api]);
      $response = $client->post($endpoint,
      [
          'http_errors'=>true,
          'headers' => [
              'Accept' => 'application/json',
          ],
          'form_params' => [
              'archivo_sunat' => $archivo_sunat,
              'tipo' => $tipo,
              'send' => true
          ],
        ]);
        $contents = (string) $response->getBody()->getContents();
        $result = json_decode($contents, true);
        $success=TRUE;
        $datos_json = response()->json([
          'success' =>  $success,
          'result' =>  $result]);

        return $datos_json;
    }

    public function procesarPdf(Request $request)
    {
      $result=env('URL_FE')."cdn/pdf/".$request->input('id').".PDF";
      $success=TRUE;
      $datos_json = response()->json([
        'success' =>  $success,
        'result' =>  $result
      ]);

        return $datos_json;
    }

}
