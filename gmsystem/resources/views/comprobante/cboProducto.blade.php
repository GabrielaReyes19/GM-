<div class="form-group" style="margin-bottom: 0px;">
    <select id="productoId{{ $id }}" name="productoId{{ $id }}" class="form-control" onchange="datosProducto{{ $id }}();">
    	<option></option>
        @foreach($cboProducto as $producto)
            <!-- <option value="{{ $producto->pk_prd_id }}">{{ $producto->nomUnidad }} - {{ $producto->c_nom }}</option> -->
            {{-- <option value="{{ $producto->pk_prd_id }}">{{ $producto->nomUnidad }} - {{ $producto->c_nom }}</option> --}}
            <option value="{{ $producto->pk_prd_id }}">{{ $producto->c_nom }}</option>
        @endforeach 
    </select>
</div><br>
<input type="hidden" name="nombreProducto{{ $id }}" id="nombreProducto{{ $id }}">
<input type="hidden" name="codigo{{ $id }}" id="codigo{{ $id }}">
<input type="hidden" name="um{{ $id }}" id="um{{ $id }}">
<input type="hidden" name="idUm{{ $id }}" id="idUm{{ $id }}">
<span id="proNom{{ $id }}" style="font-weight:bold;"></span>
<span id="proDes{{ $id }}"></span>
<script type="text/javascript">
    $('#productoId{{ $id }}').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    $('#cantidad{{ $id }}').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        calcImporte();
        return false;
      }
    });

    $('#precuni{{ $id }}').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        calcImporte();
        return false;
      }
    });
    
    $('#cantidad{{ $id }}').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9\.]/g, '');
    });

    $('#precuni{{ $id }}').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9\.]/g, '');
    });
    
	$("#productoId{{ $id }}").select2({
		// allowClear: true,
		placeholder: "SELECCIONE...",
        width: 'resolve',
		//minimumInputLength: 3,
		//multiple: false,
	});

	function datosProducto{{ $id }}(){
        var moneda=$("#idMoneda").val();
		$.ajax({
            beforeSend: function(){
                $("#cantidad{{ $id }}").val("1");
                $("#cantidad{{ $id }}").focus();
            },
            type: "GET",
            url: "{{ url('datos.producto') }}/"+$("#productoId{{ $id }}").val()+"/"+moneda,
            success : function(datos_json) {    
                if (datos_json.success != false) {
                    $("#productoId{{ $id }}").val(datos_json.id);
                    $("#codigo{{ $id }}").val(datos_json.codigo);
                    $("#nombreProducto{{ $id }}").val(datos_json.nombre);
                    $("#precuni{{ $id }}").val(datos_json.precio);
                    $("#um{{ $id }}").val(datos_json.um);
                    $("#idUm{{ $id }}").val(datos_json.idUm);
                    $("#proDes{{ $id }}").html(datos_json.descripion);
                    $("#proNom{{ $id }}").html(datos_json.nombre);
                    calcImporte();
                    $('#img-upload{{ $id }}').attr('src', 'public/images/'+datos_json.imagen);
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error:", message: "No se pudo cargar!", size: 'large' });
            },
            dataType : 'json'
        }); 
	}
</script>


