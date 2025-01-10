
<select id="cliente" name="cliente" class="form-control" onclick="datosCliente();">
    <option></option>
    @foreach($cboCliente as $cliente)
        @if($id==$cliente->pk_cli_id)
            <option value="{{ $cliente->pk_cli_id }}" selected="">{{ $cliente->c_num_doc }}  {{ $cliente->c_raz }}</option>
        @else
             <option value="{{ $cliente->pk_cli_id }}">{{ $cliente->c_num_doc }}  {{ $cliente->c_raz }}</option>
        @endif
    @endforeach 
</select>

<script type="text/javascript">
    if($("#cliente").val()!=""){
        datosCliente();
    }
    $("#cliente").select2({
		// allowClear: true,
		placeholder: "SELECCIONE...",
		//minimumInputLength: 3,
		//multiple: false,
	});
</script>
