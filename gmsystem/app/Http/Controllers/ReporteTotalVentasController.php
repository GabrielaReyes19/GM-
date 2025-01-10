<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Empresa;
use App\DocumentoComprobante;
use Barryvdh\DomPDF\Facade as PDF;
use App\Comprobante;
use DB;

class ReporteTotalVentasController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "totalVentas";
        $this->titleModule = "Total Ventas";
        $this->linkBaseModule = "reporteTotalVentas/";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $documentoComprobante = DocumentoComprobante::get();
        $cliente = Cliente::orderBy('c_raz', 'desc')->get();
        $documentoComprobante = DocumentoComprobante::get();
        return view('reporteTotalVentas.index', compact('titleModule','linkBaseModule','nameModule','documentoComprobante','cliente','documentoComprobante'));
    }

    public function imprimir(Request $request)
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $id=$request->input('id');
        $id2=$request->input('id2');
        $id3=$request->input('id3');
        session(['fechaInicio'=>$id]);
        session(['fechaFin'=>$id2]);
        session(['tDoc'=>$id3]);
        return view('reporteTotalVentas.imprimir',compact('nameModule','titleModule','linkBaseModule','id'));
    }

    public function pdf(){
        $fechaInicio=session('fechaInicio');
        $fechaFin=session('fechaFin');
        $tDoc=session('tDoc');
        //dd($fechaFin);
        if($tDoc=="-1"){
            $datoS=  DB::table("mov_comprobante")->select(DB::raw("SUM(n_tot) as count"))->where('f_hor_fac','>=',$fechaInicio)->where('f_hor_fac','<=',$fechaFin)->whereNotIn('n_est', [0])->first();
        }else{
            $datoS=  DB::table("mov_comprobante")->select(DB::raw("SUM(n_tot) as count"))->where('f_hor_fac','>=',$fechaInicio)->where('f_hor_fac','<=',$fechaFin)->where('fk_tip_doc_ven_id','=',$tDoc)->whereNotIn('n_est', [0])->first();
        }

        $total=number_format($datoS->count, 2, ",", ".");

        $empresa = Empresa::Empresa();
        $razonSocialEmisor=$empresa[0]->c_raz_soc;
        $view =  \View::make('reporteTotalVentas.pdf', compact('razonSocialEmisor','total'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();
    }
}
