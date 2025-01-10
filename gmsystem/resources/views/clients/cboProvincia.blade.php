
<select id="provincia" name="provincia" class="form-control" onclick="cargaCboDistrito(this.value,-1);">
    <option></option>
    @foreach($datos as $dato)
        @if($id2!="-1")
            @if($id == $dato->pk_pvi_id)
                <option value="{{ $dato->pk_pvi_id }}" selected="">{{ $dato->c_nom }}</option>
            @else
                <option value="{{ $dato->pk_pvi_id }}">{{ $dato->c_nom }}</option>
            @endif
        @else
            <option value="{{ $dato->pk_pvi_id }}">{{ $dato->c_nom }}</option>
        @endif

    @endforeach 
</select>

<script type="text/javascript">
    function cargaCboDistrito(id,id2)
    {
        cboDistrito(id,id2);
    }
    $("#provincia").select2({
		// allowClear: true,
		placeholder: "SELECCIONE...",
		//minimumInputLength: 3,
		//multiple: false,
	});
</script>
