@if($id2=="1")
	<option value="">[TODOS]</option> 
@else
	<option value=""></option> 
@endif()
@foreach($categoria as $dato)
	@if($dato->pk_cat_id==$id3)
        <option value="{{ $dato->pk_cat_id }}" selected="">{{ $dato->c_nom }}</option>
	@else
		<option value="{{ $dato->pk_cat_id }}">{{ $dato->c_nom }}</option>
	@endif
@endforeach  
