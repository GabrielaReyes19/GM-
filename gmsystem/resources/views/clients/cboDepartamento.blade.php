
<select id="departamento" name="departamento" class="form-control" onclick="cargaCboProvincia(this.value,-1);">
    <option></option>
    @foreach($datos as $dato)
    	@if($id == $dato->pk_dep_id)
    		<option value="{{ $dato->pk_dep_id }}" selected="">{{ $dato->c_nom }}</option>
    	@else
			<option value="{{ $dato->pk_dep_id }}">{{ $dato->c_nom }}</option>
    	@endif
    @endforeach 
</select>

<script type="text/javascript">
	function cargaCboProvincia(id,id2)
	{
		cboProvincia(id,id2);
		cboDistrito(-1,-1);
	}
    $("#departamento").select2({
		// allowClear: true,
		placeholder: "SELECCIONE...",
		//minimumInputLength: 3,
		//multiple: false,
	});
</script>
