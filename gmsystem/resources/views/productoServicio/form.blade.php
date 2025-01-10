<div class="row" id="validatorProducto">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Se han detectado las siguientes validaciones</strong>
            <div id="clasificacionId_show"></div>
            <div id="categoria_show"></div>
            <div id="proCod_show"></div>
            <div id="proNom_show"></div>
            <div id="unidadMedida_show"></div>
            <div id="moneda_show"></div>
        </div>
    </div>
</div>

{{ csrf_field() }}

<input type="hidden" name="clasificacionId" value="-1">
<input type="hidden" name="categoria" value="-1">
<input type="hidden" name="marca" value="-1">
{{-- <div class="row"> 
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Clasificaci&oacute;n:
            </label>
            <select id="clasificacionId" name="clasificacionId" class="form-control" onchange="cboCategoria($(this).val(),'2')">
                <option></option>
            </select>
        </div>
    </div> 
    <div class="col-md-4" >
        <div class="form-group" >
            <label class="control-label" >Categoria:
            </label>
            <div id="cargaCategoria">
                <select id="categoria" name="categoria" class="form-control" >
                    <option></option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4" >
        <div class="form-group" >
            <label class="control-label" >Marca:
            </label>
            <select id="marca" name="marca" class="form-control" >
                <option></option>
            </select>           
        </div>
    </div>
</div>  --}}

<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label" for="">Código Interno:</label>
                    <input type="text" class="form-control" id="proCod" name="proCod" autofocus="" autocomplete="off" value="{{ $producto->c_cod or old('c_cod')}}" />
                    <!--<span class="fa fa-edit form-control-feedback"></span>-->
                    @if($cboTipo=="2")
                        <input type="hidden" name="proCod2" value="{{ $producto->c_cod }}">
                    @endif
                </div> <!-- / .form-group -->
            </div> 
            <div class="col-md-9">
                <div class="form-group has-feedback">
                    <label class="control-label" for="">Nombre del producto o servicio</label>
                    <input type="text" class="form-control" id="proNom" name="proNom" autocomplete="off" value="{{ $producto->c_nom or old('c_nom')}}" />
                </div> <!-- / .form-group -->
            </div> 
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <!-- 5. $SUMMERNOTE_WYSIWYG_EDITOR =================================================================

                    Summernote WYSIWYG-editor
            -->
                    <script>

                            if (! $('html').hasClass('ie8')) {
                                $('#obs').summernote({
                                    height: 200,
                                    tabsize: 2,
                                    codemirror: {
                                        theme: 'monokai'
                                    }
                                });
                            }
                            $('#summernote-boxed').switcher({
                                on_state_content: '<span class="fa fa-check" style="font-size:11px;"></span>',
                                off_state_content: '<span class="fa fa-times" style="font-size:11px;"></span>'
                            });
                            // $('#summernote-boxed').on($('html').hasClass('ie8') ? "propertychange" : "change", function () {
                            //     var $panel = $(this).parents('.panel');
                            //     if ($(this).is(':checked')) {
                            //         $panel.find('.panel-body').addClass('no-padding');
                            //         $panel.find('.panel-body > *').addClass('no-border');
                            //     } else {
                            //         $panel.find('.panel-body').removeClass('no-padding');
                            //         $panel.find('.panel-body > *').removeClass('no-border');
                            //     }
                            // });

                    </script>
                    <!-- / Javascript -->

                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Descripción</span>
                        </div>
                        <div class="panel-body no-padding">
                            <textarea class="form-control" id="obs" name="obs" rows="10">{{ $producto->c_obs or old('c_obs') }}</textarea>
                        </div>
                       {{--  {!! $producto->c_obs or old('c_obs')  !!} --}}
                    </div>
            <!-- /5. $SUMMERNOTE_WYSIWYG_EDITOR -->
                </div> <!-- / .form-group -->
            </div> 
        </div>
        <div class="row">
             <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Tipo:</label>
                    <select id="unidadMedida" name="unidadMedida" class="form-control" >
                        <option></option>
                        @foreach($tipo as $dato)
                            @if($dato->pk_uni_med_id==$producto->fk_uni_med_id)
                                <option value="{{ $dato->pk_uni_med_id }}" selected="">{{ $dato->c_nom }}</option>
                            @else
                                <option value="{{ $dato->pk_uni_med_id }}">{{ $dato->c_nom }}</option>
                            @endif
                        @endforeach 
                    </select>
                </div>
            </div> 
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Moneda:</label>
                    <select id="moneda" name="moneda" class="form-control">
        <!--                 <option></option> -->
                        @foreach($moneda as $dato)
                            @if($dato->pk_mon_id==$producto->fk_mon_id)
                                <option value="{{ $dato->pk_mon_id }}" selected="">{{ $dato->c_nom }}</option>
                            @else
                                <option value="{{ $dato->pk_mon_id }}">{{ $dato->c_nom }}</option>
                            @endif
                        @endforeach 
                    </select>
                </div>
            </div> 
        <!--     <div class="col-md-2">
                <div class="form-group has-feedback">
                    <label class="control-label" for="">Precio de Compra:</label>
                    <input type="text" class="form-control" id="preCom" name="preCom" autocomplete="off" value="0.00"/>
                </div>
            </div>  -->
            <div class="col-md-2">
                <div class="form-group has-feedback">
                    <label class="control-label" for="">Precio de Venta:</label>
                    <input type="text" class="form-control" id="preVen" name="preVen" autocomplete="off" value="{{ $producto->n_pre_ven or old('n_pre_ven')}}"/>
                </div> 
            </div>  

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Estado:</label>
                    <select id="est" name="est" class="form-control">
                        <option value="1" @if($producto->n_est  == "1") {{"selected"}} @endif>ACTIVO</option>  
                        <option value="0" @if($producto->n_est  == "0") {{"selected"}} @endif>INACTIVO</option>                    
                    </select>
                </div> <!-- / .form-group -->
            </div> 
        </div>
        
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">subir imagen</label>
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                        Browse… <input type="file" id="imagen" name="imagen"> 
                    </span>
                </span>
                <input type="text" class="form-control" readonly>
            </div>
            @if($producto->c_img)
                <img id='img-upload' src="{{ asset('/public/images/'.$producto->c_img) }}" />
            @else
                <img id='img-upload' src="{{ asset('/public/images/avatar.jpg') }}" />
            @endif
        </div>
        <style type="text/css">
            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }

            #img-upload{
                width: 100%;
            }
        </style>
        <script type="text/javascript">
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function(event, label) {
                    
                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;
                    
                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }
                
                });
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        
                        reader.onload = function (e) {
                            $('#img-upload').attr('src', e.target.result);
                        }
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imagen").change(function(){
                    readURL(this);
            }); 
        </script>
    </div>
</div>



<div class="panel-footer text-right tab-content-padding no-padding">
    <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}" >
        <span class="btn-label icon fa fa-save"></span> Guardar
    </button>
    <button type="button" class="btn btn-danger btn-outline" id="cer" data-dismiss="modal" onclick="cerrar();">
        <span class="btn-label icon fa fa-times"></span> Cerrar
    </button>
</div>
