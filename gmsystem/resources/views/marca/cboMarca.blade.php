@if($id=="1")
	<option value="">[TODOS]</option> 
@else
	<option value=""></option> 
@endif()
@foreach($marca as $dato)
	@if($dato->pk_mar_id==$id2)
		<option value="{{ $dato->pk_mar_id }}" selected="">{{ $dato->c_nom }}</option>
	@else
		<option value="{{ $dato->pk_mar_id }}">{{ $dato->c_nom }}</option>
	@endif
@endforeach  
