<div class="row" id="validatorMarca">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Se han detectado las siguientes validaciones</strong>
            <div id="marNom_show"></div>
        </div>
    </div>
</div>
{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Marca:</label>
            <input type="text" class="form-control" id="marNom" name="marNom" autocomplete="off" autofocus="" value="{{ $marca->c_nom or old('c_nom')}}" />
            @if($cboTipo=="2")
                <input type="hidden" name="marNom2" value="{{ $marca->c_nom }}">
            @endif
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-md-12">
        <div class="form-group has-feedback">
            <label class="control-label" for="tal_nom">Estado:</label>
            <select id="est" name="est" class="form-control">
                <option value="1" @if($marca->n_est  == "1") {{"selected"}} @endif>ACTIVO</option>  
                <option value="0" @if($marca->n_est  == "0") {{"selected"}} @endif>INACTIVO</option>                         
            </select>
        </div>
    </div>  
</div>
<div class="panel-footer text-right tab-content-padding no-padding">
    <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
        <span class="btn-label icon fa fa-save"></span> Guardar
    </button>
    <button type="button" class="btn btn-danger btn-outline" id="cerCre" data-dismiss="modal">
        <span class="btn-label icon fa fa-times"></span> Cerrar
    </button>
</div>