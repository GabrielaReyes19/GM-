<div class="row" id="validator">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Se han detectado las siguientes validaciones</strong>
            <div id="cliDoc_show"></div>
            <div id="cliTip_show"></div>
            <div id="razNom_show"></div>
            <div id="cliApePat_show"></div>
            <div id="cliApeMat_show"></div>
            <div id="name_show"></div>
            <div id="cliDir_show"></div>
            {{-- <div id="cliTel_show"></div> --}}
            <div id="cliCor_show"></div>
            <div id="sunat_show"></div>
        </div>
    </div>
</div>
{{ csrf_field() }}

<div class="panel panel-info" style="margin-bottom: 0px;">
    <div class="panel-heading padding-xs-hr no-padding-vr">
        <span class="panel-title">Consultar RUC</span>
    </div>
    <div class="panel-body padding-xs-vr padding-xs-hr text-xs" style="padding-bottom: 0px!important;">
        <div class="row" style="padding-bottom:0px;">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label no-margin-b" for="tal_nom">Número (RUC o DNI):</label>
                    <input type="text" class="form-control" id="cliDoc" name="cliDoc" autocomplete="off" autofocus="" value="{{old('c_num_doc')}}"  />
                </div> <!-- / .form-group -->
            </div>  
            <div class="col-md-3">
                <label class="control-label no-margin-b" for="tal_nom">Acciones</label><br />
                <div id="btnBusqueda">
                    <button type="button" title="Extraer Ruc Sunat" class="btn btn-outline btn-success add-tooltip" data-placement="bottom" id="extRuc" onclick="sunatJson();">
                        <span class="btn-label icon fa fa-search"></span>
                    </button>
                    <button type="button" title="Consultar Ruc Sunat" class="btn btn-outline btn-success add-tooltip" data-placement="bottom" id="ConRuc" onclick="sunat();">
                        <span class="btn-label icon fa fa-eye"></span>
                    </button>
                </div>
                <div id="preloadBuscador"></div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="panel panel-info" style="margin-bottom: 0px;">
    <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Tipo de Documento:</label>
                    <select id="cliTip" name="cliTip" class="form-control" onchange="tipoDocumento();">
                        <option ></option>
                        @foreach($documento as $documento)
                            @if($documento->pk_tip_doc_id==1 || $documento->pk_tip_doc_id==2)
                                @if($cliente->fk_tip_doc_id==$documento->pk_tip_doc_id)
                                    <option value="{{ $documento->pk_tip_doc_id }}" selected="">{{ $documento->c_nom }}</option>
                                @else
                                    <option value="{{ $documento->pk_tip_doc_id }}">{{ $documento->c_nom }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Número de Documento:</label>
                    <input type="text" class="form-control" id="cliDocSunat" name="cliDocSunat" autocomplete="off" value="{{ $cliente->c_num_doc or old('c_num_doc')}}" />
                </div> <!-- / .form-group -->
            </div>   
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Raz&oacute;n Social:</label>
                    <input type="text" class="form-control" id="razNom" name="razNom" autocomplete="off" value="{{ $cliente->c_raz or old('c_raz')}}" />
                </div> <!-- / .form-group -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="cliApePat" name="cliApePat" autocomplete="off" value="{{ $cliente->c_pri_ape or old('c_pri_ape')}}">
                </div> <!-- / .form-group -->
            </div>         
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Apellido Materno:</label>
                    <input type="text" class="form-control" id="cliApeMat" name="cliApeMat" autocomplete="off" value="{{ $cliente->c_seg_ape or old('c_seg_ape')}}">
                </div> <!-- / .form-group -->
            </div> 
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ $cliente->c_nom or old('c_nom')}}">
                </div> <!-- / .form-group -->
            </div> 
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Dirección:</label>
                    <textarea cols="" rows="2" class="form-control input-sm" name="cliDir" id="cliDir">{{ $cliente->c_dir or old('c_dir')}}</textarea>
                </div> <!-- / .form-group -->
            </div> 
        </div>

        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Departamento:</label>
                    <div id="cargaDepartamento">
                        <select id="departamento" name="departamento" class="form-control" onchange="cboProvincia()">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div> 
             
            <div class="col-md-4" >
                <div class="form-group no-margin" >
                    <label class="control-label" >Provincia:</label>
                    <div id="cargaProvincia">
                        <select id="provincia" name="provincia" class="form-control">
                            <option></option>
                        </select>
                    </div>          
                </div>
            </div>
            
            <div class="col-md-4 no-margin" >
                <div class="form-group">
                    <label class="control-label">Distrito:</label>
                    <div id="cargaDistrito">
                        <select id="distrito" name="distrito" class="form-control">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>     
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Teléfono:</label>
                    <input type="text" class="form-control" id="cliTel" name="cliTel" autocomplete="off" value="{{ $cliente->c_tel or old('c_tel')}}" />
                    <span class="fa fa-phone form-control-feedback"></span>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Correo:</label>
                    <input type="text" class="form-control" id="cliCor" name="cliCor" autocomplete="off" value="{{ $cliente->c_cor or old('c_cor')}}"/>
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Representante:</label>
                    <input type="text" class="form-control" id="cliRep" name="cliRep" autocomplete="off" value="{{ $cliente->c_rep or old('c_rep')}}"/>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Estado:</label>
                    <select id="est" name="est" class="form-control">
                        <option value="1" @if($cliente->n_est  == "1") {{"selected"}} @endif>ACTIVO</option>  
                        <option value="0" @if($cliente->n_est  == "0") {{"selected"}} @endif>INACTIVO</option>                    
                    </select>
                </div> <!-- / .form-group -->
            </div>  
        </div>
        <div class="panel-footer text-right tab-content-padding">
            <input type="hidden" id="resultado" value="0"/>
            <input type="hidden" name="id" value="{{ $id }}">
            <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
                <span class="btn-label icon fa fa-save"></span> Guardar
            </button>
            <button type="button" class="btn btn-danger btn-outline" id="cer" data-dismiss="modal">
                <span class="btn-label icon fa fa-times"></span> Cerrar
            </button>
        </div>
    </div>
</div>
  


