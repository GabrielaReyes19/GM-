<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Sucursal;
use DB;
use Carbon\Carbon;

class CorreoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCorreo(){
        $comprobante = $request->input('comprobante');
        $numero = $request->input('numero');
        $fecha_emision = $request->input('fecha_emision');
        $fecha_vencimiento = $request->input('fecha_vencimiento');
        $total = $request->input('total');
        $cliente = $request->input('cliente');
        $correo_cliente = $request->input('correo_cliente');
        $correo_emisor = $request->input('correo_emisor');
        $archivo_sunat = $request->input('archivo_sunat');
        $empresa = $request->input('razon_social');
        $ruc = $request->input('ruc');
        $data = array(
                        'comprobante'=>''.$comprobante.'',
                        'numero'=>''.$numero.'',
                        'fecha_emision'=>''.$fecha_emision.'',
                        'fecha_vencimiento'=>''.$fecha_vencimiento.'',
                        'total'=>''.$total.'',
                        'cliente'=>''.$cliente.'',
                        'correo_cliente'=>''.$correo_cliente.'',
                        'correo_emisor'=>''.$correo_emisor.'',
                        'archivo_sunat'=>''.$archivo_sunat.'',
                        'razon_social'=>''.$empresa.'',
                        'ruc'=>''.$ruc.'',
                    );
        $logFiles = Zipper::make(public_path('/cdn/document/'.$archivo_sunat.'.ZIP'))->listFiles(); 

        Zipper::make(public_path('/cdn/document/'.$archivo_sunat.'.ZIP'))->extractTo(public_path('/cdn/document/')); 


        Mail::send('emails.comprobante', ['msg' => $data], function($m) use ($data, $archivo_sunat, $empresa, $comprobante, $numero, $cliente){
            $pdf = public_path('cdn/pdf/'.$archivo_sunat.'.PDF');
            $xml = public_path('cdn/document/'.$archivo_sunat.'.XML');
            $m->from($data["correo_emisor"], $empresa);
            $m->to($data["correo_cliente"])->subject($comprobante." ".$numero." | ".$empresa);
             $m->attach($pdf);
             $m->attach($xml);
        });
  
        File::delete(public_path('cdn/document/'.$archivo_sunat.'.XML'));

        return response()->json([
            'success' => true,
            'message' => "Correo enviado al cliente",
        ]);
    }


}
