
<select id="distrito" name="distrito" class="form-control">
    <option></option>
    @foreach($datos as $dato)
    	@if($id2!="-1")
		    @if($id == $dato->pk_dis_id)
		    	<option value="{{ $dato->pk_dis_id }}" selected="">{{ $dato->c_nom }}</option>
		    @else
				<option value="{{ $dato->pk_dis_id }}">{{ $dato->c_nom }}</option>
		    @endif
    	@else
				<option value="{{ $dato->pk_dis_id }}">{{ $dato->c_nom }}</option>
    	@endif
    @endforeach 
</select>

<script type="text/javascript">
    $("#distrito").select2({
		// allowClear: true,
		placeholder: "SELECCIONE...",
		//minimumInputLength: 3,
		//multiple: false,
	});
</script>
